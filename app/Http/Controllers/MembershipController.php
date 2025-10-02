<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipSubscription;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MembershipController extends Controller
{
    /**
     * Display the membership plans page
     */
    public function index(): View
    {
        $memberships = Membership::active()
            ->ordered()
            ->get();

        return view('membership', compact('memberships'));
    }

    /**
     * Show membership details and initiate checkout
     */
    public function show(Membership $membership): View
    {
        if (!$membership->is_active) {
            abort(404, 'Membership plan not available');
        }

        return view('membership.show', compact('membership'));
    }

    /**
     * Initiate membership checkout
     */
    public function checkout(Request $request, Membership $membership): RedirectResponse
    {
        if (!$membership->is_active) {
            return back()->with('error', 'This membership plan is not available.');
        }

        // Check if user already has an active membership
        $user = $request->user();
        if ($user && $user->hasActiveMembership()) {
            return back()->with('error', 'You already have an active membership. Please wait for it to expire before purchasing a new one.');
        }

        // Store membership checkout data in session
        $request->session()->put('checkout_data', [
            'type' => 'membership',
            'membership_id' => $membership->_id,
            'membership' => [
                'id' => $membership->_id,
                'name' => $membership->name,
                'description' => $membership->description,
                'price' => (float) $membership->price,
                'duration_months' => $membership->duration_months,
                'benefits' => $membership->benefits,
            ]
        ]);

        return redirect()->route('checkout.index');
    }

    /**
     * Display user's membership subscriptions
     */
    public function myMemberships(Request $request): View
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your memberships.');
        }

        $subscriptions = $user->membershipSubscriptions()
            ->with('membership')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeSubscription = $user->activeMembershipSubscription();

        return view('membership.my-memberships', compact('subscriptions', 'activeSubscription'));
    }

    /**
     * Cancel a membership subscription
     */
    public function cancel(Request $request, MembershipSubscription $subscription): RedirectResponse
    {
        $user = $request->user();
        
        if (!$user || $subscription->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized access.');
        }

        if ($subscription->isCancelled()) {
            return back()->with('error', 'This membership is already cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500'
        ]);

        $subscription->cancel($request->input('cancellation_reason'));

        return back()->with('success', 'Your membership has been cancelled successfully.');
    }

    /**
     * Renew a membership subscription
     */
    public function renew(Request $request, MembershipSubscription $subscription): RedirectResponse
    {
        $user = $request->user();
        
        if (!$user || $subscription->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized access.');
        }

        if (!$subscription->isExpired()) {
            return back()->with('error', 'You can only renew expired memberships.');
        }

        // Store membership checkout data in session for renewal
        $request->session()->put('checkout_data', [
            'type' => 'membership_renewal',
            'membership_id' => $subscription->membership_id,
            'subscription_id' => $subscription->_id,
            'membership' => [
                'id' => $subscription->membership->_id,
                'name' => $subscription->membership->name,
                'description' => $subscription->membership->description,
                'price' => (float) $subscription->membership->price,
                'duration_months' => $subscription->membership->duration_months,
                'benefits' => $subscription->membership->benefits,
            ]
        ]);

        return redirect()->route('checkout.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipPurchase;
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
     * Purchase membership - redirect to checkout
     */
    public function purchase(Request $request, Membership $membership): RedirectResponse
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
                'duration_days' => $membership->duration_days,
                'benefits' => $membership->benefits,
            ]
        ]);

        return redirect()->route('checkout.index');
    }

    /**
     * Display user's membership management page
     */
    public function myMemberships(Request $request): View
    {
        $user = $request->user();
        $activeMembership = $user->activeMembershipPurchase();
        $membershipHistory = $user->membershipPurchases()
            ->with('membership')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('membership.my-memberships', compact('activeMembership', 'membershipHistory'));
    }

    /**
     * Cancel user's active membership
     */
    public function cancel(Request $request, MembershipPurchase $membershipPurchase): RedirectResponse
    {
        $user = $request->user();
        
        // Check if the membership belongs to the user
        if ($membershipPurchase->user_id !== $user->id) {
            return back()->with('error', 'You can only cancel your own memberships.');
        }

        // Check if membership is active
        if (!$membershipPurchase->isActive()) {
            return back()->with('error', 'This membership is not active.');
        }

        // Update membership status
        $membershipPurchase->update(['status' => 'cancelled']);

        return back()->with('success', 'Your membership has been cancelled successfully.');
    }

    /**
     * Renew user's expired membership
     */
    public function renew(Request $request, MembershipPurchase $membershipPurchase): RedirectResponse
    {
        $user = $request->user();
        
        // Check if the membership belongs to the user
        if ($membershipPurchase->user_id !== $user->id) {
            return back()->with('error', 'You can only renew your own memberships.');
        }

        // Check if membership is expired
        if (!$membershipPurchase->isExpired()) {
            return back()->with('error', 'This membership is not expired.');
        }

        // Store membership checkout data in session for renewal
        $request->session()->put('checkout_data', [
            'type' => 'membership_renewal',
            'membership_id' => $membershipPurchase->membership_id,
            'membership' => [
                'id' => $membershipPurchase->membership_id,
                'name' => $membershipPurchase->membership->name,
                'description' => $membershipPurchase->membership->description,
                'price' => (float) $membershipPurchase->membership->price,
                'duration_days' => $membershipPurchase->membership->duration_days,
                'benefits' => $membershipPurchase->membership->benefits,
            ]
        ]);

        return redirect()->route('checkout.index');
    }
}

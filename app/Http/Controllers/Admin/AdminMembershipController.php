<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipSubscription;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminMembershipController extends Controller
{
    /**
     * Display all membership plans
     */
    public function index(): View
    {
        $memberships = Membership::ordered()->get();
        $totalSubscriptions = MembershipSubscription::count();
        $activeSubscriptions = MembershipSubscription::active()->count();
        $expiredSubscriptions = MembershipSubscription::expired()->count();

        return view('admin.memberships.index', compact(
            'memberships', 
            'totalSubscriptions', 
            'activeSubscriptions', 
            'expiredSubscriptions'
        ));
    }

    /**
     * Show the form for creating a new membership plan
     */
    public function create(): View
    {
        return view('admin.memberships.create');
    }

    /**
     * Store a newly created membership plan
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1|max:12',
            'benefits' => 'required|array|min:1',
            'benefits.*' => 'required|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'max_uses_per_month' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Membership::create($validated);

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Membership plan created successfully');
    }

    /**
     * Display the specified membership plan
     */
    public function show(Membership $membership): View
    {
        $subscriptions = $membership->subscriptions()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $activeSubscriptions = $membership->activeSubscriptions()->count();
        $totalRevenue = $membership->subscriptions()->sum('amount_paid');

        return view('admin.memberships.show', compact(
            'membership', 
            'subscriptions', 
            'activeSubscriptions', 
            'totalRevenue'
        ));
    }

    /**
     * Show the form for editing the specified membership plan
     */
    public function edit(Membership $membership): View
    {
        return view('admin.memberships.edit', compact('membership'));
    }

    /**
     * Update the specified membership plan
     */
    public function update(Request $request, Membership $membership): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1|max:12',
            'benefits' => 'required|array|min:1',
            'benefits.*' => 'required|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'max_uses_per_month' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $membership->update($validated);

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Membership plan updated successfully');
    }

    /**
     * Remove the specified membership plan
     */
    public function destroy(Membership $membership): RedirectResponse
    {
        // Check if there are active subscriptions
        if ($membership->activeSubscriptions()->count() > 0) {
            return back()->with('error', 'Cannot delete membership plan with active subscriptions.');
        }

        $membership->delete();

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Membership plan deleted successfully');
    }

    /**
     * Display all membership subscriptions
     */
    public function subscriptions(): View
    {
        $subscriptions = MembershipSubscription::with(['user', 'membership'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => MembershipSubscription::count(),
            'active' => MembershipSubscription::active()->count(),
            'expired' => MembershipSubscription::expired()->count(),
            'cancelled' => MembershipSubscription::cancelled()->count(),
        ];

        return view('admin.memberships.subscriptions', compact('subscriptions', 'stats'));
    }

    /**
     * Show subscription details
     */
    public function showSubscription(MembershipSubscription $subscription): View
    {
        $subscription->load(['user', 'membership', 'order']);

        return view('admin.memberships.subscription-details', compact('subscription'));
    }

    /**
     * Cancel a subscription (admin action)
     */
    public function cancelSubscription(Request $request, MembershipSubscription $subscription): RedirectResponse
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        $subscription->cancel($request->input('cancellation_reason'));

        return back()->with('success', 'Subscription cancelled successfully.');
    }

    /**
     * Renew a subscription (admin action)
     */
    public function renewSubscription(MembershipSubscription $subscription): RedirectResponse
    {
        if (!$subscription->isExpired()) {
            return back()->with('error', 'Can only renew expired subscriptions.');
        }

        $subscription->renew();

        return back()->with('success', 'Subscription renewed successfully.');
    }
}

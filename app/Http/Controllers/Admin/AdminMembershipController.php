<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipPurchase;
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
        $totalPurchases = MembershipPurchase::count();
        $activeMemberships = MembershipPurchase::active()->count();
        $expiredMemberships = MembershipPurchase::expired()->count();

        return view('admin.memberships.index', compact(
            'memberships', 
            'totalPurchases', 
            'activeMemberships', 
            'expiredMemberships'
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
            'duration_days' => 'required|integer|min:1',
            'benefits' => 'required|array|min:1',
            'benefits.*' => 'required|string|max:255',
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
            'duration_days' => 'required|integer|min:1',
            'benefits' => 'required|array|min:1',
            'benefits.*' => 'required|string|max:255',
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
        // Check if there are active purchases
        if ($membership->purchases()->active()->count() > 0) {
            return back()->with('error', 'Cannot delete membership plan with active purchases.');
        }

        $membership->delete();

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Membership plan deleted successfully');
    }

    /**
     * Display all membership purchases
     */
    public function purchases(): View
    {
        $purchases = MembershipPurchase::with(['user', 'membership'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => MembershipPurchase::count(),
            'active' => MembershipPurchase::active()->count(),
            'expired' => MembershipPurchase::expired()->count(),
        ];

        return view('admin.memberships.purchases', compact('purchases', 'stats'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Membership;
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
}

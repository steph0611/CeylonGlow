<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_id' => 'required|string',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check the form for errors.');
        }

        // Get service details
        $service = Service::find($request->service_id);
        if (!$service) {
            return redirect()->back()
                ->with('error', 'Service not found.')
                ->withInput();
        }

        // Create booking
        $booking = Booking::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'service_id' => $request->service_id,
            'service_name' => $service->name,
            'service_price' => $service->price,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_date . ' ' . $request->booking_time,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        return redirect()->back()
            ->with('success', 'Booking request submitted successfully! We will contact you soon to confirm.');
    }

    public function show($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Please check the form for errors.');
        }

        $booking->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->back()
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        $booking->delete();

        return redirect()->back()
            ->with('success', 'Booking deleted successfully.');
    }
}


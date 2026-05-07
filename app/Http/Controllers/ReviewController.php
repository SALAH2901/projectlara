<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class ReviewController extends Controller
{
    public function store(Request $request, Appointment $appointment)
    {
        // Authorize that the user is the patient of this appointment
        if (auth()->id() !== $appointment->patient_id) {
            abort(403);
        }

        // Check if appointment is completed
        if ($appointment->status !== 'completed') {
            return back()->withErrors(['review' => 'You can only review completed appointments.']);
        }

        // Check if review already exists
        if ($appointment->review()->exists()) {
            return back()->withErrors(['review' => 'You have already reviewed this appointment.']);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $appointment->review()->create([
            'patient_id' => auth()->id(),
            'doctor_id' => $appointment->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('status', 'review-submitted');
    }
}

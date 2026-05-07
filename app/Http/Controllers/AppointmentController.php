<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'consultation_notes' => 'nullable|string'
        ]);

        $isUnavailable = \App\Models\DoctorUnavailability::where('doctor_id', $request->doctor_id)
            ->where('start_date', '<=', $request->appointment_date)
            ->where('end_date', '>=', $request->appointment_date)
            ->exists();

        if ($isUnavailable) {
            return back()->withErrors(['appointment_date' => 'The doctor is not available on the selected date.'])->withInput();
        }

        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'consultation_notes' => $request->consultation_notes,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Appointment requested successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Doctor accepting/completing/canceling
        if (auth()->user()->role === 'doctor') {
            abort_if(auth()->id() !== $appointment->doctor_id, 403);
            
            $request->validate(['status' => 'required|in:accepted,completed,canceled']);
            $appointment->update(['status' => $request->status]);
            
            return back()->with('success', 'Appointment status updated.');
        } 
        // Patient canceling
        else {
            abort_if(auth()->id() !== $appointment->patient_id, 403);
            
            $request->validate(['status' => 'required|in:canceled']);
            $appointment->update(['status' => $request->status]);
            
            return back()->with('success', 'Appointment canceled.');
        }
    }

    public function updateNotes(Request $request, Appointment $appointment)
    {
        abort_if(auth()->user()->role !== 'doctor', 403);
        abort_if(auth()->id() !== $appointment->doctor_id, 403);
        
        $request->validate([
            'consultation_notes' => 'nullable|string'
        ]);

        $appointment->update([
            'consultation_notes' => $request->consultation_notes
        ]);

        return back()->with('success', 'Consultation notes saved.');
    }
}

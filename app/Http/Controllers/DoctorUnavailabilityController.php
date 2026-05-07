<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorUnavailability;

class DoctorUnavailabilityController extends Controller
{
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'doctor', 403);

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:255',
        ]);

        // Check if there are existing unavailabilities that overlap
        $overlap = DoctorUnavailability::where('doctor_id', auth()->id())
            ->where(function($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function($q) use ($request) {
                          $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['start_date' => 'You already have an unavailability block that overlaps with these dates.'])->withInput();
        }

        DoctorUnavailability::create([
            'doctor_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Unavailability dates added successfully.');
    }

    public function destroy(DoctorUnavailability $unavailability)
    {
        abort_if(auth()->id() !== $unavailability->doctor_id, 403);

        $unavailability->delete();

        return back()->with('success', 'Unavailability deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorProfile;

class DoctorSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'doctor')->with('doctorProfile');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhereHas('doctorProfile', function($q2) use ($search) {
                      $q2->where('specialization', 'like', "%{$search}%");
                  });
            });
        }

        $doctors = $query->paginate(12);

        return view('patient.doctors.index', compact('doctors'));
    }

    public function show(User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);
        
        $doctor->load('doctorProfile');
        $unavailabilities = $doctor->unavailabilities()->where('end_date', '>=', today())->orderBy('start_date')->get();
        return view('patient.doctors.show', compact('doctor', 'unavailabilities'));
    }
}

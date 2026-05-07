<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'doctor') {
            // Stats
            $totalPending = $user->doctorAppointments()->where('status', 'pending')->count();
            $totalAccepted = $user->doctorAppointments()->where('status', 'accepted')->count();
            $totalCompleted = $user->doctorAppointments()->where('status', 'completed')->count();
            
            $todayAppointments = $user->doctorAppointments()->with('patient')
                ->whereDate('appointment_date', now()->toDateString())
                ->whereIn('status', ['accepted', 'completed'])
                ->orderBy('appointment_time')
                ->get();
                
            $unreadMessages = $user->receivedMessages()->whereNull('read_at')->count();

            // Filtered Appointments
            $query = $user->doctorAppointments()->with('patient');
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('date')) {
                $query->whereDate('appointment_date', $request->date);
            } else {
                // Default to upcoming if no date filter
                $query->whereDate('appointment_date', '>=', now()->toDateString());
            }

            $appointments = $query->orderBy('appointment_date')->orderBy('appointment_time')->get();

            $unavailabilities = $user->unavailabilities()->where('end_date', '>=', now()->toDateString())->orderBy('start_date')->get();

            return view('dashboard', compact('appointments', 'totalPending', 'totalAccepted', 'totalCompleted', 'todayAppointments', 'unreadMessages', 'unavailabilities'));
        } else {
            $appointments = $user->patientAppointments()->with('doctor')->orderBy('appointment_date', 'desc')->get();
            return view('dashboard', compact('appointments'));
        }
    }
}

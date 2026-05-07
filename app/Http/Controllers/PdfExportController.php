<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportController extends Controller
{
    public function exportPatientHistory()
    {
        $user = auth()->user();
        abort_if($user->role !== 'patient', 403);

        $appointments = $user->patientAppointments()
            ->with(['doctor.doctorProfile'])
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.patient-history', compact('user', 'appointments'));
        return $pdf->download('medical_history_' . str_replace(' ', '_', $user->name) . '.pdf');
    }

    public function exportDoctorSchedule()
    {
        $user = auth()->user();
        abort_if($user->role !== 'doctor', 403);

        $appointments = $user->doctorAppointments()
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $pdf = Pdf::loadView('pdf.doctor-schedule', compact('user', 'appointments'));
        return $pdf->download('appointment_schedule_' . str_replace(' ', '_', $user->name) . '.pdf');
    }
}

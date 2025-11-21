<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $r)
    {
        $user = $r->user();
        $totalProducts = Product::when(!isAdmin(), fn ($q) => $q->where('user_id', $user->id))->count();
        $totalAppointments = Appointment::when(!isAdmin(), fn ($q) => $q->where('clinician_id', $user->id))->count();
        $upcomingAppointments = Appointment::when(!isAdmin(), fn ($q) => $q->where('clinician_id', $user->id))
                          ->whereBetween('appointment_date', [now(), now()->addDays(7)])->count();

        return view('dashboard', compact('totalProducts', 'totalAppointments', 'upcomingAppointments'));
    }
}

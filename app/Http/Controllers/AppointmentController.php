<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreAppointmentRequest;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        // $this->middleware(['role:Admin|Clinician']);
    }

    public function index()
    {
        return view('appointments.index');
    }

    public function data(Request $request)
    {
        $query = Appointment::with('clinician')
            ->forUser(auth()->user())
            ->latest();

        return DataTables::of($query)
            ->addColumn('clinician', function ($row) {
                return $row->clinician->name;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('appointments.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form action="' . route('appointments.destroy', $row->id) . '" method="POST" class="d-inline">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button class="btn btn-danger btn-sm" onclick="return confirm(\'Delete?\')">Del</button></form>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $clinicians = isAdmin()
            ? User::where('role', 'Clinician')->get()
            : [auth()->user()];

        return view('appointments.create', compact('clinicians'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        Appointment::create($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully');
    }

    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $clinicians = isAdmin()
            ? User::where('role', 'Clinician')->get()
            : [auth()->user()];

        return view('appointments.edit', compact('appointment', 'clinicians'));
    }

    public function update(StoreAppointmentRequest $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}

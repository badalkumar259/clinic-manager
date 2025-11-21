<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $query = Appointment::with(['clinician'])
                ->when(!isAdmin(), fn ($q) => $q->where('clinician_id', $user->id));
        $appointments = $query->paginate(15);

        return api_success($appointments);
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        return api_success($appointment->load('category', 'subcategory'));
    }

    public function store(StoreAppointmentRequest $r)
    {
        $data = $r->validated();
        $data['clinician_id'] = $r->user()->id;
        $appointment = Appointment::create($data);
        activity_log('created', $appointment, $r->user());

        return api_success($appointment, 'Product created', 201);
    }

    public function update(StoreAppointmentRequest $r, Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $appointment->update($r->validated());
        activity_log('updated', $appointment, $r->user());

        return api_success($appointment, 'Updated');
    }

    public function destroy(Request $r, Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        activity_log('deleted', $appointment, $r->user());
        $appointment->delete();

        return api_success(null, 'Deleted', 200);
    }
}

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add New Appointment</h3>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Patient Name</label>
            <input type="text" name="patient_name" class="form-control" value="{{ old('patient_name', $appointment->patient_name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Clinic Location</label>
            <input type="text" name="clinic_location" class="form-control" value="{{ old('clinic_location', $appointment->clinic_location ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Clinician</label>
            <select name="clinician_id" class="form-control" @if(auth()->user()->hasRole('Clinician')) disabled @endif required>
                @foreach($clinicians as $clinician)
                    <option value="{{ $clinician->id }}" 
                        {{ isset($appointment) && $appointment->clinician_id == $clinician->id ? 'selected' : '' }}>
                        {{ $clinician->name }}
                    </option>
                @endforeach
            </select>
            @if(auth()->user()->hasRole('Clinician'))
                <input type="hidden" name="clinician_id" value="{{ auth()->id() }}">
            @endif
        </div>

        <div class="mb-3">
            <label>Appointment Date</label>
            <input type="datetime-local" name="appointment_date" class="form-control" value="{{ old('appointment_date', isset($appointment) ? $appointment->appointment_date : '') }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach(['Booked'] as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>
       

        <button class="btn btn-success" type="submit">Save</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
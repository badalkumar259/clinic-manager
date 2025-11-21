@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Appointment</h3>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('appointments.update',$appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Patient Name</label>
            <input type="text" name="patient_name" value="{{ $appointment->patient_name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Clinician</label>
            <select name="clinician_id" class="form-control" required>
                @foreach($clinicians as $cl)
                    <option value="{{ $cl->id }}" {{ $cl->id==$appointment->clinician_id?'selected':'' }}>
                        {{ $cl->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Appointment Date</label>
            <input type="datetime-local" name="appointment_date" value="{{ date('Y-m-d\TH:i',strtotime($appointment->appointment_date)) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Booked" {{ $appointment->status=='Booked'?'selected':'' }}>Booked</option>
                <option value="Completed" {{ $appointment->status=='Completed'?'selected':'' }}>Completed</option>
                <option value="Cancelled" {{ $appointment->status=='Cancelled'?'selected':'' }}>Cancelled</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
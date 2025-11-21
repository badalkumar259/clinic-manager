@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Appointments</h2>

    <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">+ Add Appointment</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="appointments-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Patient</th>
            <th>Location</th>
            <th>Clinician</th>
            <th>Date</th>
            <th>Status</th>
            <th width="150">Actions</th>
        </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#appointments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('appointments.data') }}',
        columns: [
            { data: 'patient_name', name: 'patient_name' },
            { data: 'clinic_location', name: 'clinic_location' },
            { data: 'clinician', name: 'clinician.name' },
            { data: 'appointment_date', name: 'appointment_date' },
            { data: 'status', name: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
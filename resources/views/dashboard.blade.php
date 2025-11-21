@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>

<div class="row mt-4">

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h4>Total Products</h4>
            <h2>{{ $totalProducts }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h4>Total Appointments</h4>
            <h2>{{ $totalAppointments }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h4>Upcoming (7 Days)</h4>
            <h2>{{ $upcomingAppointments }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h4>User</h4>
            <h2>{{ auth()->user()->name }}</h2>
            <p>{{ auth()->user()->role }}</p>
        </div>
    </div>

</div>
@endsection
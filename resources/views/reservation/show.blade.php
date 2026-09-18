@extends('layouts.page')

@php
    $arrival_h_m_s = explode(':', $reservation->arrival);
    $arrival = "{$arrival_h_m_s[0]}:{$arrival_h_m_s[1]}";
@endphp

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="display-5 section-title mb-4">Reservering details</h1>
            <div class="card card-body-container p-4 shadow-sm">
                <h3 class="h4 card-title mb-3">{{ $reservation->name }}</h3>
                <p class="mb-1"><strong>Personen:</strong> {{ $reservation->amount_of_people }}</p>
                <p class="mb-1"><strong>Datum:</strong> {{ $reservation->date->format('d-m-Y') }}</p>
                <p class="mb-1"><strong>Tijd:</strong> {{ $arrival }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $reservation->email }}</p>
                <p class="mb-1"><strong>Telefoon:</strong> {{ $reservation->phone_number }}</p>
                <p class="mb-1"><strong>Reserveringsnummer:</strong> {{ $reservation->number }}</p>
                @if ($reservation->comment)
                    <p class="mb-1"><strong>Opmerking:</strong> {{ $reservation->comment }}</p>
                @endif
                <p class="text-muted text-small-muted mb-0">Gemaakt op {{ $reservation->created_at }}</p>
            </div>
        </div>
    </div>
@endsection

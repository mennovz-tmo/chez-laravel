@extends('layouts.page')

@php
    $arrival_h_m_s = explode(':', $reservation->arrival);
    $arrival = "{$arrival_h_m_s[0]}:{$arrival_h_m_s[1]}";
@endphp

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="display-5 mb-4" style="font-weight:300;">Reservering details</h1>
            <div class="card shadow-sm p-4" style="background:var(--earth-cream);border-color:var(--earth-light);border-radius:8px;">
                <h3 class="h4 mb-3" style="font-family:'Cormorant Garamond',serif;font-weight:600;">{{ $reservation->name }}</h3>
                <p class="mb-1"><strong>Personen:</strong> {{ $reservation->amount_of_people }}</p>
                <p class="mb-1"><strong>Datum:</strong> {{ $reservation->date->format('d-m-Y') }}</p>
                <p class="mb-1"><strong>Tijd:</strong> {{ $arrival }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $reservation->email }}</p>
                <p class="mb-1"><strong>Telefoon:</strong> {{ $reservation->phone_number }}</p>
                <p class="mb-1"><strong>Reserveringsnummer:</strong> {{ $reservation->number }}</p>
                @if($reservation->comment)
                    <p class="mb-1"><strong>Opmerking:</strong> {{ $reservation->comment }}</p>
                @endif
                <p class="mb-0 text-muted" style="font-size:0.85rem;">Gemaakt op {{ $reservation->created_at }}</p>
            </div>
        </div>
    </div>
@endsection

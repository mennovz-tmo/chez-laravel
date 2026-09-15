@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7 card p-4 shadow-sm card-body-container">
            <h1>Controleer je e-mail</h1>
            <p>
                We hebben een e-mail gestuurd naar <strong>{{ $reservation->email }}</strong> met een link om de reservering
                te
                verwijderen. Klik op de link in de e-mail om het verwijderen te bevestigen. De link is 24 uur geldig.
            </p>
            <p>
                Geen e-mail ontvangen? Vraag de verwijdering <a
                    href="{{ route('reservation.delete.request', $reservation->id) }}">opnieuw aan</a>.
                Mocht er toch nog iets zijn kunt u ons altijd bellen op 06 12345678.
            </p>
        </div>
    </div>
@endsection
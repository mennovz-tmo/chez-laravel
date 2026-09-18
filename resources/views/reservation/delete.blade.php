@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8 card card-body-container p-4 shadow-sm">
            <h1>Controleer je e-mail</h1>
            <p>
                We hebben een e-mail gestuurd naar <strong>{{ $reservation->email }}</strong> met een link om de
                reservering te verwijderen. Klik op de link in de e-mail om het verwijderen te bevestigen. De link is 24
                uur geldig.
            </p>
            <p>Geen e-mail ontvangen? Vraag de verwijdering
            <form method="post" action="{{ route('reservation.delete.request', $reservation) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 align-baseline">opnieuw aan</button>
            </form>
            . Mocht er toch nog iets zijn kunt u ons altijd bellen op 06 12345678.
            </p>
        </div>
    </div>
@endsection

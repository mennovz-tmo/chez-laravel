@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4 shadow-sm card-container">
                <h2 class="mb-4 display-5 section-title">Bevestig je e-mailadres</h2>
                <p class="mb-3">
                    Er is een verificatielink naar <strong>{{ auth()->user()?->email }}</strong> gestuurd.
                    Klik op de link in de e-mail om je account te activeren.
                    Staat de e-mail er niet tussen? Kijk ook in je spam-map.
                </p>
                <form action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">Stuur verificatielink opnieuw</button>
                </form>
                <div class="mt-4 text-center">
                    <p class="mb-0">Verkeerd e-mailadres? <a href="{{ route('logout') }}">Log uit</a> en maak een nieuw account.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
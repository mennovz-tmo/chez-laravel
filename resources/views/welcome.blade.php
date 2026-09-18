@extends('layouts.page')

@section('content')
    <div class="row align-items-center min-vh-75">
        <div class="col-md-7">
            <h1 class="display-3 heading-display">Chez Laravel</h1>
            <p class="lead tagline-italic mt-3">Burgers sinds 1974. simpel, eerlijk, met de hand gemaakt.</p>
            <a href="{{ route('menu') }}" class="btn btn-primary btn-lg mt-4 px-4 py-3">Bekijk alle menu items</a>
        </div>
        <div class="col-md-5 d-none d-md-block text-end">
            <div class="hero-banner">&#9829;</div>
        </div>
    </div>
    @if (! (count($recipes ?? []) < 1))
        <h1 class="display-4 section-title mb-4">Menu voorbeeld</h1>
        <div class="row g-4">
            @foreach ($recipes as $recipe)
                <div class="col-md-6 col-lg-4">
                    <article class="card card-custom h-100 shadow-sm">
                        @if ($recipe->picture)
                            <img
                                src="{{ $recipe->picture }}"
                                class="card-img-top"
                                alt="{{ $recipe->name }}"
                                class="card-image"
                            />
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center card-placeholder">
                                {{ $recipe->name }}
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title h4 card-title">{{ $recipe->name }}</h3>
                            <p class="card-text card-text-muted">{{ $recipe->description_short }}</p>
                            <p class="text-small-rust mb-2">Allergenen: {{ $recipe->allergens }}</p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
@endsection

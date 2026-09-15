@extends('layouts.page')

@section('content')
    <div class="row align-items-center min-vh-75">
        <div class="col-md-7">
            <h1 class="display-3 heading-display">Chez Laravel</h1>
            <p class="lead mt-3 tagline-italic">
                Burgers sinds 1974. simpel, eerlijk, met de hand gemaakt.
            </p>
            <a href="{{ route('menu') }}" class="btn btn-primary btn-lg mt-4 px-4 py-3">Bekijk alle menu items</a>
        </div>
        <div class="col-md-5 text-end d-none d-md-block">
            <div class="hero-banner">
                &#9829;
            </div>
        </div>
    </div>
    <h1 class="display-4 mb-4 section-title">Menu voorbeeld</h1>
    <div class="row g-4">
        @if (! (count($recipes ?? []) < 1))
            @foreach ($recipes as $recipe)
                @php
                    $id = $recipe['id'];
                    $name = $recipe['name'];
                    $description = $recipe['description_short'];
                    $allergens = $recipe['allergens'];
                    $price = $recipe['price'];
                    $picture = $recipe['picture'];
                @endphp
                <div class="col-md-6 col-lg-4">
                    <article class="card h-100 shadow-sm card-custom">
                        @if($picture)
                            <img src="{{ $picture }}" class="card-img-top" alt="{{ $name }}" class="card-image">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center card-placeholder">
                                {{ substr($name, 0, 1) }}
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title h4 card-title">{{ $name }}</h3>
                            <p class="card-text card-text-muted">{{ $description }}</p>
                            <p class="mb-2 text-small-rust">Allergenen: {{ $allergens }}</p>
                        </div>
                    </article>
                </div>
            @endforeach
        @endif
    </div>
@endsection
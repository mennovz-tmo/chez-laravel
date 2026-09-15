@extends('layouts.page')

@section('content')
    <h1 class="display-4 mb-4 section-title">Menukaart</h1>
    <div class="row g-4">
        @if (count($recipes ?? []) < 1)
            <div class="col-12">
                <p>Er zijn nog geen items op de menukaart.</p>
            </div>
        @else
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
                            <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                                <span class="h4 mb-0 price-display">€{{ $price }}</span>
                                @if (isStaff())
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('recipe.edit', ['recipe' => $id]) }}" class="btn btn-outline-dark btn-sm">Bewerk</a>
                                        <button type="button" class="btn btn-dark btn-sm btn-dark-custom" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-recipe-{{ $id }}">Verwijder</button>
                                        @include('components.confirm-modal', ['uid' => 'recipe-' . $id, 'url' => route('recipe.delete', ['recipe' => $id]), 'message' => 'Dit recept wordt permanent verwijderd.'])
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        @endif
    </div>
@endsection
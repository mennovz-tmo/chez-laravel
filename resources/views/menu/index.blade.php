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
                <div class="col-md-6 col-lg-4">
                    <article class="card h-100 shadow-sm card-custom">
                        @if($recipe->picture)
                            <img src="{{ $recipe->picture }}" class="card-img-top" alt="{{ $recipe->name }}" class="card-image">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center card-placeholder">
                                {{ $recipe->name }}
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title h4 card-title">{!! $recipe->name !!}</h3>
                            <p class="card-text card-text-muted">{{ $recipe->description_short }}</p>
                            <p class="mb-2 text-small-rust">Allergenen: {{ $recipe->allergens }}</p>
                            <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                                <span class="h4 mb-0 price-display">€{{ $recipe->price }}</span>
                                @if (isStaff())
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('recipe.edit', $recipe) }}" class="btn btn-outline-dark btn-sm">Bewerk</a>
                                        <button type="button" class="btn btn-dark btn-sm btn-dark-custom" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-recipe-{{ $recipe->id }}">Verwijder</button>
                                        @include('components.confirm-modal', ['uid' => 'recipe-' . $recipe->id, 'url' => route('recipe.delete', $recipe), 'message' => 'Dit recept wordt permanent verwijderd.'])
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

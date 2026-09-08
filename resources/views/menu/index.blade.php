@extends('layouts.page')

@section('content')
    <div class="row mt-3">
        @if (count($recipes) < 1)
            <div>Er zijn geen items op de menukaart aanwezig!</div>
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

                <div class="card col-4">
                    <img src="{{ $picture }}" class="card-img-top " alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $name }}</h5>
                        <p class="card-text">
                            {{ $description }} -- Allergenen: {{ $allergens }}
                        </p>
                        <a href="#" class="btn btn-primary">€{{ $price }}</a>
                        @auth
                            <a href="/admin/recipe/delete/{{ $id }}" class="btn btn-danger">Verwijderen van menu</a>
                        @endauth
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

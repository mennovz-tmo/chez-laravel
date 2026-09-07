@extends('layouts.page')

@section('content')
    <div class="row mt-3">
        @foreach ($recipes as $recipe)
            @php
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
                </div>
            </div>
        @endforeach
    </div>
@endsection

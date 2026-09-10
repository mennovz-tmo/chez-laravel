@extends('layouts.page')

@php
    // dd($current_data)
@endphp

@section('content')
    <form action="edit" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Naam van het recept:</label>
            <input required type="text" class="form-control" id="name" name="name" value="{{ $current_data['name'] }}">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Korte omschrijving recept</label>
            <textarea required class="form-control" name="description_short" id="description_short" placeholder="Geef een korte omschrijving van het recept, ongeveer 2 zinnen.">{{ $current_data['description_short'] }}</textarea>
        </div>
        <div class="mb-3">
            <label for="allergens" class="form-label">Allergenen in het recept</label>
            <input required type="text" class="form-control" id="allergens" name="allergens" value="{{ $current_data['allergens'] }}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prijs van het recept</label>
            <input required type="number" class="form-control" id="price" name="price" step="0.01" min="0.01" value="{{ $current_data['price'] }}">
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Foto van het recept</label>
            @if (!empty($current_data['picture']))
                <div class="mb-2">
                    <img src="{{ $current_data['picture'] }}" alt="Huidige foto van het recept" style="max-width: 250px; height: auto;" class="img-thumbnail">
                    <div class="form-text">Huidige foto. Laat het veld hieronder leeg om deze te behouden.</div>
                </div>
            @endif
            <input type="file" class="form-control" id="picture" name="picture" accept=".png,.jpg,.webp,.avif,.jpeg,image/png,image/jpeg,image/webp">
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@extends('layouts.page')

@section('content')
    <form action="create" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Naam van het recept:</label>
            <input required type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Korte omschrijving recept</label>
            <textarea required name="description_short" id="description_short" cols="30" rows="10"
                placeholder="Geef een korte omschrijving van het recept, ongeveer 2 zinnen.">{{ old('description_short') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="allergens" class="form-label">Allergenen in het recept</label>
            <input required type="text" class="form-control" id="allergens" name="allergens" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prijs van het recept</label>
            <input required type="number" class="form-control" id="price" name="price" step="0.01" min="0.01"
                value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Foto van het recept</label>
            <input required type="file" class="form-control" id="picture" name="picture"
                accept=".png,.jpg,.webp,.avif,.jpeg,image/png,image/jpeg,image/webp" value="{{ old('picture') }}">
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

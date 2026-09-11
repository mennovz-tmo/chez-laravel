@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="display-5 mb-4" style="font-weight:300;">Recept bewerken</h1>
            <form action="edit" method="post" enctype="multipart/form-data" class="card p-4 shadow-sm"
                style="background:var(--earth-cream);border-color:var(--earth-light);border-radius:8px;">
                @php
                @endphp
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Naam</label>
                    <input required type="text" class="form-control" id="name" name="name"
                        value="{{ $current_data['name'] }}"
                        style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                </div>
                <div class="mb-3">
                    <label for="description_short" class="form-label">Korte omschrijving</label>
                    <textarea required class="form-control" name="description_short" id="description_short" rows="3"
                        style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">{{ $current_data['description_short'] }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="allergens" class="form-label">Allergenen</label>
                    <input required type="text" class="form-control" id="allergens" name="allergens"
                        value="{{ $current_data['allergens'] }}"
                        style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prijs</label>
                    <input required type="number" class="form-control" id="price" name="price" step="0.01" min="0.01"
                        value="{{ $current_data['price'] }}"
                        style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                </div>
                <div class="mb-3">
                    <label for="picture" class="form-label">Nieuwe foto (laat leeg om te behouden)</label>
                    @if (!empty($current_data['picture']))
                        <div class="mb-2">
                            <img src="{{ $current_data['picture'] }}" alt="Huidige foto"
                                style="max-width:200px;height:auto;border-radius:4px;" class="img-thumbnail border-0 shadow-sm">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="picture" name="picture"
                        accept=".png,.jpg,.webp,.avif,.jpeg,image/png,image/jpeg,image/webp"
                        style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                </div>
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-5 section-title mb-4">Recept bewerken</h1>
            <form
                action="{{ route('recipe.edit', ['recipe' => $current_data['id']]) }}"
                method="post"
                enctype="multipart/form-data"
                class="card card-body-container p-4 shadow-sm"
            >
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Naam</label>
                    <input
                        required
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="{{ old('name', $current_data['name']) }}"
                    />
                </div>
                <div class="mb-3">
                    <label for="description_short" class="form-label">Korte omschrijving</label>
                    <textarea required class="form-control" name="description_short" id="description_short" rows="3">
                        {{ old('description_short', $current_data['description_short']) }}
                    </textarea>
                </div>
                <div class="mb-3">
                    <label for="allergens" class="form-label">Allergenen</label>
                    <input
                        required
                        type="text"
                        class="form-control"
                        id="allergens"
                        name="allergens"
                        value="{{ old('allergens', $current_data['allergens']) }}"
                    />
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prijs</label>
                    <input
                        required
                        type="number"
                        class="form-control"
                        id="price"
                        name="price"
                        step="0.01"
                        min="0.01"
                        value="{{ old('price', $current_data['price']) }}"
                    />
                </div>
                <div class="mb-3">
                    <label for="picture" class="form-label">Nieuwe foto (laat leeg om te behouden)</label>
                    @if (! empty($current_data['picture']))
                        <div class="mb-2">
                            <img
                                src="{{ $current_data['picture'] }}"
                                alt="Huidige foto"
                                class="img-thumbnail-custom img-thumbnail border-0 shadow-sm"
                            />
                        </div>
                    @endif
                    <input
                        type="file"
                        class="form-control"
                        id="picture"
                        name="picture"
                        accept=".png,.jpg,.webp,.avif,.jpeg,image/png,image/jpeg,image/webp"
                    />
                </div>
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.page')

@section('content')
    <form action="create" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Naam van het recept:</label>
            <input type="text" class="form-control" id="name" name="name" value="Chazz Burger">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Korte omschrijving recept</label>
            <textarea name="description_short" id="description_short" cols="30" rows="10"
                placeholder="Geef een korte omschrijving van het recept, ongeveer 2 zinnen.">Een mooie burger met veel vlees. En zoals elke burger veel te groot om in je mond te stoppen!</textarea>
        </div>
        <div class="mb-3">
            <label for="allergens" class="form-label">Allergenen in het recept</label>
            <input type="text" class="form-control" id="allergens" name="allergens" value="Gluten (tarwe)">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prijs van het recept</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0.01"
                value="25.99">
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Foto van het recept</label>
            <input type="file" class="form-control" id="picture" name="picture"
                accept=".png,.jpg,.webp,.avif,.jpeg,image/png,image/jpeg,image/webp">
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

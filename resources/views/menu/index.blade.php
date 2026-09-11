@extends('layouts.page')

@section('content')
<h1 class="display-4 mb-4" style="font-weight:300;">Menukaart</h1>
<div class="row g-4">
    @if (count($recipes ?? []) < 1)
        <div class="col-12"><p>Er zijn nog geen items op de menukaart.</p></div>
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
                <article class="card h-100 shadow-sm" style="border:1px solid var(--earth-light);border-radius:8px;background:var(--earth-cream);">
                    @if($picture)
                    <img src="{{ $picture }}" class="card-img-top" alt="{{ $name }}" style="border-radius:8px 8px 0 0;height:220px;object-fit:cover;opacity:0.95;">
                    @else
                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height:220px;background:var(--earth-rust);border-radius:8px 8px 0 0;color:#fff;font-family:'Cormorant Garamond',serif;font-size:2.5rem;">{{ substr($name,0,1) }}</div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title h4" style="font-family:'Cormorant Garamond',serif;font-weight:600;">{{ $name }}</h3>
                        <p class="card-text" style="color:var(--earth-mid);">{{ $description }}</p>
                        <p class="mb-2" style="font-size:0.85rem;color:var(--earth-rust);">Allergenen: {{ $allergens }}</p>
                        <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                            <span class="h4 mb-0" style="font-family:'Cormorant Garamond',serif;color:var(--earth-dark);">€{{ $price }}</span>
                            @auth
                            <div class="d-flex gap-2">
                                <a href="/recipe/{{ $id }}/edit" class="btn btn-outline-dark btn-sm">Bewerk</a>
                                <a href="/recipe/{{ $id }}/delete" class="btn btn-dark btn-sm" style="background:var(--earth-dark);border-color:var(--earth-dark);">Verwijder</a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    @endif
</div>
@endsection

@extends('layouts.page')

@section('nav')
    @extends('components.nav')
@endsection

@section('content')
    {{-- @dd($recipes) --}}
    @foreach ($recipes as $recipe)
        @php
            $name = $recipe['name'];
        @endphp

        <div class="g-col-4"><p>{{ $name }}</p></div>
    @endforeach
@endsection

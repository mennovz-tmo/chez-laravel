@extends('layouts.page')

@section('content')
    <div class="row align-items-center min-vh-75">
        <div class="col-md-7">
            <h1 class="display-3" style="font-weight:300;line-height:1.1;">Chez Laravel</h1>
            <p class="lead mt-3"
                style="font-family:'Cormorant Garamond',serif;font-size:1.6rem;color:var(--earth-rust);font-style:italic;">
                Burgers sinds 1974. simpel, eerlijk, met de hand gemaakt.
            </p>
            <a href="/menu" class="btn btn-primary btn-lg mt-4 px-4 py-3">Bekijk de kaart</a>
        </div>
        <div class="col-md-5 text-end d-none d-md-block">
            <div
                style="width:100%;height:320px;background:linear-gradient(135deg,#8B5A3C 0%,#6B3A2A 100%);border-radius:4px;opacity:0.9;display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:4rem;color:#F5F0E8;letter-spacing:-0.05em;">
                &#9829;
            </div>
        </div>
    </div>
@endsection
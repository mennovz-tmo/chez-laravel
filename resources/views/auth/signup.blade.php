@extends('layouts.page')

@section('content')
    <form action="register" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Wat is je naam?</label>
            <input required type="text" class="form-control" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Wat is je email?</label>
            <input required type="email" class="form-control" name="email" id="email" placeholder="mail@example.com" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Vul een sterk wachtwoord in:</label>
            <input required type="password" class="form-control" id="password" name="password" min="12" max="128" placeholder="Een sterk wachtwoord bevat speciale tekens, kleine en grote letters en cijfers." value="{{ old('password') }}">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Herhaal je sterke wachtwoord</label>
            <input required type="password" class="form-control" id="password_confirmation" name="password_confirmation" min="12" max="128" placeholder="Herhaal je wachtwoord.">
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Registreer je account</button>
    </form>
    <div class="mt-4">
        <p>Heb je al een account? <a href="login">login</a>.</p>
    </div>
@endsection

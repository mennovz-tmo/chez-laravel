@extends('layouts.page')

@section('content')
    <form action="login" method="post">
        <div class="mb-3">
            <label for="pass" class="form-label">Wat is je email?</label>
            <input required type="email" class="form-control" name="email" id="email" placeholder="mail@example.com" value="{{ old('email') }}">
        </div>
        <div class="mb-1">
            <label for="password" class="form-label">Vul je wachtwoord in:</label>
            <input required type="password" class="form-control" id="password" name="password" min="12" max="128" placeholder="...........">
        </div>
        <div class="mb-3">
            <label for="remeber">Onthoud mij!</label>
            <input type="checkbox" name="remember" id="remember" class="checkbox">
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <div class="mt-4">
        <p>Heb je nog geen account? <a href="signup">Maak een account</a>.</p>
    </div>
@endsection

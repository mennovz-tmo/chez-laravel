@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4 shadow-sm card-container">
                <h2 class="mb-4 display-5 section-title">Inloggen</h2>
                <form action="{{ route('login.submit') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input required type="email" class="form-control" name="email" id="email"
                            placeholder="mail@example.com" value="{{ old('email') }}" class="form-input">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Wachtwoord</label>
                        <input required type="password" class="form-control" id="password" name="password" min="12"
                            max="128" placeholder="..........." class="form-input">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input form-check">
                        <label for="remember" class="form-check-label">Onthoud mij</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                @if (Config::get('auth.account_creation_enabled'))
                    <div class="mt-4 text-center">
                        <p class="mb-0">Geen account? <a href="{{ route('register') }}">Maak er een</a>.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4 shadow-sm"
                style="border-radius:8px;background:var(--earth-cream);border-color:var(--earth-light);">
                <h2 class="mb-4 display-5" style="font-weight:300;">Inloggen</h2>
                <form action="login" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input required type="email" class="form-control" name="email" id="email"
                            placeholder="mail@example.com" value="{{ old('email') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Wachtwoord</label>
                        <input required type="password" class="form-control" id="password" name="password" min="12"
                            max="128" placeholder="..........."
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input"
                            style="border-color:var(--earth-mid);">
                        <label for="remember" class="form-check-label">Onthoud mij</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="mt-4 text-center">
                    <p class="mb-0">Geen account? <a href="signup">Maak er een</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
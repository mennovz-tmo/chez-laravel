@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card p-4 shadow-sm"
                style="border-radius:8px;background:var(--earth-cream);border-color:var(--earth-light);">
                <h2 class="mb-4 display-5" style="font-weight:300;">Account aanmaken</h2>
                <form action="register" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input required type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                            value="{{ old('name') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input required type="email" class="form-control" id="email" name="email"
                            placeholder="mail@example.com" value="{{ old('email') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Wachtwoord</label>
                        <input required type="password" class="form-control" id="password" name="password" min="12"
                            max="128" placeholder="Sterk wachtwoord..." value="{{ old('password') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Herhaal wachtwoord</label>
                        <input required type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" min="12" max="128" placeholder="Herhaal..."
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registreer</button>
                </form>
                <div class="mt-4 text-center">
                    <p class="mb-0">Al een account? <a href="login">Log in</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
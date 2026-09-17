@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-5 mb-4 section-title">Gebruiker {{ $user['name'] }} aanpassen</h1>
            <form action="{{ route('manage.users.edit.store', $user) }}" method="post"
                class="card p-4 shadow-sm card-body-container">
                <div class="mb-3">
                    <label for="name" class="form-label">Naam</label>
                    <input required type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                        value="{{ old('name', $user->name) }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Emailadres</label>
                    <input required type="email" class="form-control" id="email" name="email" placeholder="mail@example.com"
                        value="{{ old('email', $user->email) }}">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Account rol</label>
                    <select name="role" id="role">
                        <option value="staff" @if($user->role == 'staff')selected @endif>Staff</option>
                        <option value="consumer" @if($user->role == 'consumer')selected @endif>Gebruiker</option>
                    </select>
                </div>

                @csrf
                <button type="submit" class="m-2 btn btn-primary">Gebruiker aanpassen</button>
            </form>
        </div>
    </div>
@endsection
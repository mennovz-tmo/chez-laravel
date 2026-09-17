@extends('layouts.page')

@section('content')
    <h1 class="display-4 mb-4 section-title">Gebruikers</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Naam</th>
                <th>Rol</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td>
                        <a href="{{ route('manage.users.edit', ['user' => $user['id']]) }}"
                            class="btn btn-outline-dark btn-sm mt-1">Bewerk</a>
                        <button type="button" class="btn btn-dark btn-sm mt-1 btn-dark-custom" data-bs-toggle="modal"
                            data-bs-target="#confirmModal-res-{{ $user['id'] }}">Verwijder</button>
                        @include('components.confirm-modal', ['uid' => 'res-'.$user['id'], 'url' => route('manage.users.delete', ['user' => $user['id']]), 'message' => 'Dit account wordt *PERMANENT* verwijderd. Dat is erg lang!'])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
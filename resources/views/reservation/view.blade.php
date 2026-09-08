@extends('layouts.page')

@section('content')
    <form action="view" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Wat is het emailadres van de reservering(en)?</label>
            <div class="row">
                <input required type="text" class="col-8" id="email" name="email" placeholder="John Doe" value="{{ old('email') }}">
                <button type="submit" class="col-4 btn btn-primary">Zoek uw reservering</button>
            </div>
        </div>
    </form>

    @if (request()->isMethod('post'))
        @forelse ($reserveringen as $reservering)
            @php
                $id = $reservering['id'];
                $number = $reservering['number'];
                $name = $reservering['name'];
                $amount_of_people = $reservering['amount_of_people'];
                $phone_number = $reservering['phone_number'];
                $comment = $reservering['comment'];
                $date = $reservering['date'];
                $arrival = $reservering['arrival'];
                $created_at = $reservering['created_at'];
            @endphp

            <div class="card mb-2 p-2">
                <p>
                    Reservering: {{ $number }} voor {{ $amount_of_people }} personen.
                </p>
                <p>
                    Telefoon nummer: {{ $phone_number }}
                </p>
                <p>
                    Gereserveerd voor: {{ $date }} om {{ $arrival }}.
                </p>
                <p>
                    Reservering gemaakt op: {{ $created_at }}
                </p>
                @auth
                    <div class="d-grid gap-2 d-flex justify-content-end">
                        <a href="/admin/reservation/delete/{{ $id }}" class="flex-end max-25 btn btn-danger">Verwijder reservering</a>
                    </div>
                @endauth
            </div>
        @empty
            <p>Geen reseveringen gevonden voor email: {{ $email }}</p>
        @endforelse
    @endif
@endsection
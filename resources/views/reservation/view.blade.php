@extends('layouts.page')

@section('content')
    <form action="reservation" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Wat is het emailadres van de reservering(en)?</label>
            <div class="row">
                <input @guest required @endguest type="text" class="col-8" id="email" name="email" placeholder="John Doe"
                    value="{{ old('email') }}">
                <button type="submit" class="col-4 btn btn-primary">Zoek uw reservering</button>
            </div>
        </div>
    </form>
    @if (!empty($reservations))
        @php
            $count = count($reservations);
        @endphp
        <div class="mb-2">
            @if (! empty($email))
                <p>Er zijn totaal {{ $count }} reserveringen voor {{ $email }}</p>
            @else
                <p>Alle reserveringen worden laten zien</p>
            @endif
        </div>
        @forelse ($reservations as $reservation)
            @php
                $id = $reservation['id'];
                $number = $reservation['number'];
                $name = $reservation['name'];
                $amount_of_people = $reservation['amount_of_people'];
                $reservation_email = $reservation['email'];
                $phone_number = $reservation['phone_number'];
                $comment = $reservation['comment'];
                $date = $reservation['date']->format('d-m-Y');
                $arrival_h_m_s = explode(':', $reservation['arrival']);
                $arrival = "{$arrival_h_m_s[0]}:{$arrival_h_m_s[1]}";
                $created_at = $reservation['created_at'];
            @endphp

            <div class="card mb-2 p-2">
                @auth
                    <p>
                        Reservering gemaakt op naam: {{ $name }} <br>
                        Reserveerder telefoon: {{ $phone_number }} <br>
                        Reserveerder email: {{ $reservation_email }}
                    </p>
                    @if (!empty($comment))
                        <p>
                            Opmerking: {{ $comment }}
                        </p>
                    @endif
                    <p>
                        Gereserveerde datum {{ $date }} vanaf {{ $arrival }} uur. Met {{ $amount_of_people }} mensen. <br>
                        Reservering gedaan op: {{ $created_at }}.
                    </p>
                    <p>
                        Technische info: <br>
                        Reserverings nummer: {{ $number }} <br>
                        Debug reserverings nummer: ({{ $id }})
                    </p>
                @else
                    <p>
                        Reservering gemaakt op naam: {{ $name }} voor {{ $amount_of_people }} personen. <br>
                        Reservering voor {{ $date }} vanaf {{ $arrival }}.
                    </p>
                    <p>
                        Vermelde opmerking: {{ $comment }}
                    </p>
                    <p>
                        Technische info: <br>
                        Reserverings nummer: {{ $number }}
                    </p>
                @endauth
                <div class="d-grid gap-2 d-flex justify-content-start">
                    <a href="reservation/{{ $id }}/delete" class="btn btn-danger">Verwijder reservering</a>
                    <a href="reservation/{{ $id }}/edit" class="btn btn-warning">Reservering aanpassen</a>
                </div>
                @guest
                    <small class="text-muted">Je ontvangt eerst een e-mail met een link om het verwijderen te bevestigen.</small>
                @endguest
            </div>
        @empty
            @if (empty($email))
                <p>Er zijn geen reserveringen.</p>
            @else
                <p>Geen reseveringen gevonden voor email: {{ $email }}</p>
            @endif
        @endforelse
    @endif
@endsection
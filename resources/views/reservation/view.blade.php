@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="display-5 mb-4" style="font-weight:300;">Zoek reservering</h1>
            <form action="reservation" method="post" class="card p-4 shadow-sm"
                style="background:var(--earth-cream);border-color:var(--earth-light);border-radius:8px;">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label for="email" class="form-label">Emailadres</label>
                        <input @guest required @endguest type="text" class="form-control" id="email" name="email"
                            placeholder="John Doe" value="{{ old('email') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Zoek</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (!empty($reservations))
        <h2 class="h3 mt-5 mb-3" style="font-family:'Cormorant Garamond',serif;font-weight:600;">
            @if (!empty($email)) Reserveringen voor {{ $email }} @else Alle reserveringen @endif
        </h2>
        <div class="row g-3">
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
                    $arrival = explode(':', $reservation['arrival']);
                    $arrival = $arrival[0] . ':' . $arrival[1];
                    $created_at = $reservation['created_at'];
                @endphp
                <div class="col-12">
                    <div class="card shadow-sm p-3"
                        style="background:var(--earth-cream);border-color:var(--earth-light);border-radius:8px;">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="h5 mb-2" style="font-family:'Cormorant Garamond',serif;font-weight:600;">{{ $name }}</h3>
                                <p class="mb-1" style="font-size:0.9rem;color:var(--earth-mid);">
                                    {{ $date }} vanaf {{ $arrival }} voor {{ $amount_of_people }} personen.
                                </p>
                                @auth
                                    <p class="mb-0" style="font-size:0.85rem;color:var(--earth-rust);">Telefoon: {{ $phone_number }}</p>
                                @endauth
                            </div>
                            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                @auth
                                    <button type="button" class="btn btn-dark btn-sm" style="background:var(--earth-dark);border-color:var(--earth-dark);" data-bs-toggle="modal" data-bs-target="#confirmModal-res-{{ $id }}">Verwijder</button>
                                    @include('components.confirm-modal', ['uid' => 'res-'.$id, 'url' => 'reservation/'.$id.'/delete', 'message' => 'Deze reservering wordt permanent verwijderd.'])
                                    <a href="reservation/{{ $id }}/show" class="btn btn-outline-dark btn-sm">Bekijk</a>
                                    <a href="reservation/{{ $id }}/edit" class="btn btn-outline-dark btn-sm">Bewerk</a>
                                @else
                                    <button type="button" class="btn btn-dark btn-sm" style="background:var(--earth-dark);border-color:var(--earth-dark);" data-bs-toggle="modal" data-bs-target="#confirmModal-res-{{ $id }}">Annuleer</button>
                                    @include('components.confirm-modal', ['uid' => 'res-'.$id, 'url' => 'reservation/'.$id.'/delete', 'message' => 'Deze reservering wordt geannuleerd.'])
                                    <a href="reservation/{{ $id }}/show" class="btn btn-outline-dark btn-sm">Bekijk</a>
                                @endauth
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top"
                            style="border-color:var(--earth-light);font-size:0.75rem;color:var(--earth-mid);">
                            Reserveringsnummer: {{ $number }} · Gemaakt op {{ $created_at }}
                        </div>
                    </div>
                </div>
            @empty
                <p>Geen reserveringen gevonden.</p>
            @endforelse
        </div>
    @endif
@endsection
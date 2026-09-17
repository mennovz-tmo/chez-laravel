@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-5 mb-4 section-title">Zoek reservering</h1>
            <form action="{{ route('reservation.view') }}" method="post" class="card p-4 shadow-sm card-body-container">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="start" class="form-label">Van</label>
                        <input type="date" class="form-control" id="start" name="start"
                            value="{{ old('start', $start ?? '') }}" min="{{ now()->format('Y-m-d') }}"
                            max="{{ now()->modify('+61 days')->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end" class="form-label">Tot</label>
                        <input type="date" class="form-control" id="end" name="end" value="{{ old('end', $end ?? '') }}"
                            max="{{ now()->modify('+61 days')->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Naam"
                            value="{{ old('name', $name ?? '') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label">Emailadres</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="john@example.com"
                            value="{{ old('email', $email ?? '') }}">
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="@auth col-md-6 @endauth @guest col-md-12 @endguest">
                        <button type="submit" class="btn btn-primary w-100">Zoek</button>
                    </div>
                    @if (isStaff())
                        <div class="col-md-6 d-flex gap-2">
                            <a href="{{ route('reservation.view', ['start' => now()->format('Y-m-d'), 'end' => now()->format('Y-m-d')]) }}"
                                class="btn btn-outline-dark w-50">Vandaag</a>
                            <a href="{{ route('reservation.view', ['start' => now()->addDay()->format('Y-m-d'), 'end' => now()->addDay()->format('Y-m-d')]) }}"
                                class="btn btn-outline-dark w-50">Morgen</a>
                        </div>
                    @endif
                </div>
            </form>

            @if (!empty($reservations))
                <h2 class="h3 mt-5 mb-3 card-title">
                    @if (!empty($email)) Reserveringen voor {{ $email }} @else Reserveringen @endif
                    @if (!empty($start)) <small class="text-muted">tussen {{ $start }} en {{ $end ?? $start }}</small> @endif
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
                            <div class="card shadow-sm p-3 card-body-container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="h5 mb-2 card-title">{{ $name }}</h3>
                                        <p class="mb-1 text-subtitle">
                                            {{ $date }} vanaf {{ $arrival }} voor {{ $amount_of_people }} personen.
                                        </p>
                                        @if (isStaff())
                                            <p class="mb-0 text-small-rust">Telefoon: {{ $phone_number }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                        @if (isStaff())
                                            <button type="button" class="btn btn-dark btn-sm mt-1 btn-dark-custom"
                                                data-bs-toggle="modal" data-bs-target="#confirmModal-res-{{ $id }}">Verwijder</button>
                                            @include('components.confirm-modal', ['uid' => 'res-' . $id, 'url' => route('reservation.delete.request', ['reservation' => $id]), 'message' => 'Deze reservering wordt permanent verwijderd.'])
                                            <a href="{{ route('reservation.show', ['reservation' => $id]) }}"
                                                class="btn btn-outline-dark btn-sm mt-1">Bekijk</a>
                                            <a href="{{ route('reservation.edit', ['reservation' => $id]) }}"
                                                class="btn btn-outline-dark btn-sm mt-1">Bewerk</a>
                                        @else
                                            <button type="button" class="btn btn-dark btn-sm btn-dark-custom" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-res-{{ $id }}">Annuleer</button>
                                            @include('components.confirm-modal', ['uid' => 'res-' . $id, 'url' => route('reservation.delete.request', ['reservation' => $id]), 'message' => 'Deze reservering wordt verwijderd na een korte verificatie.'])
                                            <a href="{{ route('reservation.show', ['reservation' => $id]) }}"
                                                class="btn btn-outline-dark btn-sm">Bekijk</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-top border-top-light">
                                    Reserveringsnummer: {{ $number }} · Gemaakt op {{ $created_at }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Geen reserveringen gevonden.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
@endsection
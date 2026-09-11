@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="display-5 mb-4" style="font-weight:300;">Reserveren</h1>
            <form action="create" method="post" class="card p-4 shadow-sm"
                style="background:var(--earth-cream);border-color:var(--earth-light);border-radius:8px;">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Naam</label>
                        <input required type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                            value="{{ old('name') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input required type="email" class="form-control" name="email" id="email"
                            placeholder="mail@example.com" value="{{ old('email') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Telefoon</label>
                        <input required type="tel" class="form-control" name="phone_number" id="phone_number"
                            placeholder="06 12345678" pattern="[0-9]{2} [0-9]{8}" value="{{ old('phone_number') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="col-md-6">
                        <label for="amount_of_people" class="form-label">Aantal personen</label>
                        <input required type="number" class="form-control" name="amount_of_people" id="amount_of_people"
                            placeholder="4" min="1" max="99" value="{{ old('amount_of_people') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="col-md-6">
                        @php
                            $min = new Datetime()->modify('+1 day');
                            $max = $min->modify('+28 days');
                        @endphp
                        <label for="date" class="form-label">Datum</label>
                        <input required type="date" class="form-control" name="date" id="date"
                            min="{{ $min->format('d-m-Y') }}" value="{{ old('date') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="col-md-6">
                        <label for="arrival" class="form-label">Tijd (16:00 - 22:00)</label>
                        <input required type="time" class="form-control" name="arrival" id="arrival" min="16:00" max="22:00"
                            value="{{ old('arrival') }}"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">
                    </div>
                    <div class="col-12">
                        <label for="comment" class="form-label">Opmerking</label>
                        <textarea class="form-control" name="comment" id="comment" rows="2"
                            style="border-radius:2px;background:var(--earth-paper);border-color:var(--earth-light);color:var(--earth-dark);">{{ old('comment') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Reserveren</button>
            </form>
            <div class="mt-3">
                <p>Heb je al een reservering? <a href="/reservation">Bekijk hier</a>.</p>
            </div>
        </div>
    </div>
@endsection
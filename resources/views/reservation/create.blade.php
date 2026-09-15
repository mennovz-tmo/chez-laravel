@extends('layouts.page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-5 mb-4 section-title">Reserveren</h1>
            <form action="create" method="post" class="card p-4 shadow-sm card-body-container">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Naam</label>
                        <input required type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                            value="{{ old('name') }}" class="form-input">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input required type="email" class="form-control" name="email" id="email"
                            placeholder="mail@example.com" value="{{ old('email') }}" class="form-input">
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Telefoon</label>
                        <input required type="tel" class="form-control" name="phone_number" id="phone_number"
                            placeholder="Telefoon" value="{{ old('phone_number') }}" class="form-input">
                    </div>
                    <div class="col-md-6">
                        <label for="amount_of_people" class="form-label">Aantal personen</label>
                        <input required type="number" class="form-control" name="amount_of_people" id="amount_of_people"
                            placeholder="4" min="1" max="99" value="{{ old('amount_of_people') }}" class="form-input">
                    </div>
                    <div class="col-md-6">
                        @php
                            $min = new Datetime()->modify('+1 day');
                            $max = new Datetime()->modify('+61 days');
                        @endphp
                        <label for="date" class="form-label">Datum</label>
                        <input required type="date" class="form-control" name="date" id="date"
                            min="{{ $min->format('Y-m-d') }}" max="{{ $max->format('Y-m-d') }}" value="{{ old('date') }}"
                            class="form-input">
                    </div>
                    <div class="col-md-6">
                        <label for="arrival" class="form-label">Tijd</label><br>
                        <input required type="time" class="form-control" name="arrival" id="arrival"
                            value="{{ old('arrival') }}" class="form-input">
                    </div>
                    <div class="col-12">
                        <p class="text-end text-small-muted m-0 p-0">De standaard openingstijden zijn: {{ $weekly_opening_time }} tot {{ $weekly_closing_time }}*</p>
                    </div>
                    <div class="col-12">
                        <label for="comment" class="form-label">Opmerking</label>
                        <textarea class="form-control" name="comment" id="comment" rows="2"
                            class="form-input">{{ old('comment') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Reserveren</button>
            </form>
            <div class="mt-3">
                <p>Heb je al een reservering? <a href="/reservation">Bekijk hier</a>.</p>
            </div>
            
            @guest
                <div class="mt-3 card p-4 shadow-sm card-body-container">
                    <p class="m-0 p-0">
                        Er zijn data waarop wij aangepaste openingstijden hebben. Bekijk deze <a href="/opening-datetime">hier</a>
                    </p>
                </div>
            @endguest
        </div>
    </div>
@endsection
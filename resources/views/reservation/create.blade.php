@extends('layouts.page')

@section('content')
    <form action="reservation/create" method="post">
        <div class="m-1">
            <label for="name" class="form-label">Wat is je naam?</label>
            <input required type="text" class="form-control" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Wat is je email?</label>
            <input required type="email" class="form-control" name="email" id="email" placeholder="mail@example.com" value="{{ old('email') }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Wat is je telefoon nummer?</label>
            <input required type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="06 12345678" pattern="[0-9]{2} [0-9]{8}" value="{{ old('phone_number') }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Voor hoeveel mensen reserveer je?</label>
            <input required type="number" class="form-control" name="amount_of_people" id="amount_of_people" placeholder="bijvoorbeeld: 4" min="1" max="99" value="{{ old('amount_of_people') }}">
        </div>
        <div class="m-1">
            @php
                $min = new Datetime();
                $max = $min->modify('+28 days');
            @endphp
            <label for="pass" class="form-label">Voor welke datum reserveer je?</label>
            <input required type="date" class="form-control" name="date" id="date" min="{{ $min->format('d-m-Y') }}" max="{{ $max->format('d-m-Y') }}" value="{{ old('date') }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Welke tijd verwacht je er te zijn?</label>
            <input required type="time" class="form-control" name="arrival" id="arrival" min="15:00" max="23:00" value="{{ old('arrival') }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Opmerking(en) over de reservering:</label>
            <textarea class="form-control" name="comment" id="comment">{{ old('comment') }}</textarea>
        </div>

        @csrf
        <button type="submit" class="m-2 btn btn-primary">Doe een reservering</button>
    </form>
    <div class="ms-2">
        Heb je al een reservering? <a href="reservation/view" class="link-success">klik hier</a>
    </div>
@endsection

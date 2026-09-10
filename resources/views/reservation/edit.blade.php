@extends('layouts.page')

@php
    $arrival_h_m_s = explode(':', $current_data['arrival']);
    $arrival = "{$arrival_h_m_s[0]}:{$arrival_h_m_s[1]}";
@endphp

@section('content')
    <form action="edit" method="post">
        <div class="m-1">
            <label for="name" class="form-label">Wat is je naam?</label>
            <input required type="text" class="form-control" id="name" name="name" placeholder="John Doe" value="{{ $current_data['name'] }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Wat is je email?</label>
            <input required type="email" class="form-control" name="email" id="email" placeholder="mail@example.com" value="{{ $current_data['email'] }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Wat is je telefoon nummer?</label>
            <input required type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="06 12345678" pattern="[0-9]{2} [0-9]{8}" value="{{ $current_data['phone_number'] }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Voor hoeveel mensen reserveer je?</label>
            <input required type="number" class="form-control" name="amount_of_people" id="amount_of_people" placeholder="bijvoorbeeld: 4" min="1" max="99" value="{{ $current_data['amount_of_people'] }}">
        </div>
        <div class="m-1">
            @php
                $min = new Datetime();
                $max = $min->modify('+28 days');
            @endphp
            <label for="pass" class="form-label">Voor welke datum reserveer je?</label>
            <input required type="date" class="form-control" name="date" id="date" min="{{ $min->format('d-m-Y') }}" max="{{ $max->format('d-m-Y') }}" value="{{ $current_data['date'] }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Welke tijd verwacht je er te zijn?</label>
            <input required type="time" class="form-control" name="arrival" id="arrival" min="16:00" max="22:00" value="{{ $arrival }}">
        </div>
        <div class="m-1">
            <label for="pass" class="form-label">Opmerking(en) over de reservering:</label>
            <textarea class="form-control" name="comment" id="comment">{{ $current_data['comment'] }}</textarea>
        </div>

        @csrf
        <button type="submit" class="m-2 btn btn-primary">Doe een reservering</button>
    </form>
@endsection

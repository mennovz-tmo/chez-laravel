@extends('layouts.page')

@section('content')
    <h1 class="display-5 mb-4 section-title">Bewerken</h1>
    <form method="post" action="{{ route('opening-datetime.edit', ['openingDatetime' => $item]) }}" class="card p-4 shadow-sm card-body-container">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label for="date" class="form-label">Datum</label>
                <input name="date" id="date" type="date" value="{{ $item->date->format('Y-m-d') }}" required
                    class="form-input">
            </div>
            <div class="col-md-4">
                <label for="open" class="form-label">Status</label>
                <select name="open" id="open" class="form-input">
                    <option value="1" @if($item->open) selected @endif>Open</option>
                    <option value="0" @if(!$item->open) selected @endif>Gesloten</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="opening" class="form-label">Opening</label>
                <input name="opening" id="opening" type="time"
                    value="@if($item->opening != null){{ $item->opening->format('H:i') }}@endif" class="form-input">
            </div>
            <div class="col-md-4">
                <label for="closing" class="form-label">Sluiting</label>
                <input name="closing" id="closing" type="time"
                    value="@if($item->closing != null){{ $item->closing->format('H:i') }}@endif" class="form-input">
            </div>
        </div>
        <button type="submit" class="btn btn-dark btn-rust mt-4">Opslaan</button>
    </form>
@endsection
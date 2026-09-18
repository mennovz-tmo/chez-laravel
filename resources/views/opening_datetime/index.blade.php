@extends('layouts.page')

@section('content')
    @if (is_staff())
        <h1 class="section-title">Nieuw</h1>
        <form
            method="post"
            action="{{ route('opening-datetime.create') }}"
            class="card card-body-container p-4 shadow-sm"
        >
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="date" class="form-label">Datum</label>
                    <input name="date" id="date" type="date" required class="form-control" />
                </div>
                <div class="col-md-4">
                    <label for="open" class="form-label">Status</label>
                    <select name="open" id="open" class="form-control">
                        <option value="1">Open</option>
                        <option value="0">Gesloten</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="opening" class="form-label">Opening</label>
                    <input name="opening" id="opening" type="time" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label for="closing" class="form-label">Sluiting</label>
                    <input name="closing" id="closing" type="time" class="form-control" />
                </div>
            </div>
            <button type="submit" class="btn btn-dark btn-rust mt-4">Toevoegen</button>
        </form>
    @endif

    <h2 class="display-5 section-title mb-4">Speciale openingstijden</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Open</th>
                <th>Opening</th>
                <th>Sluiting</th>
                @if (is_staff())
                    <th>Acties</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->date->format('d-m-Y') }}</td>
                    <td>{{ $item->open ? 'Ja' : 'Nee' }}</td>
                    <td>
                        @if ($item->opening != null)
                            {{ $item->opening->format('H:i') }}
                        @endif
                    </td>
                    <td>
                        @if ($item->closing != null)
                            {{ $item->closing->format('H:i') }}
                        @endif
                    </td>
                    @if (is_staff())
                        <td>
                            <a
                                href="{{ route('opening-datetime.edit', ['openingDatetime' => $item->id]) }}"
                                class="btn btn-sm btn-outline-dark"
                            >Bewerk</a>
                            <button
                                class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmModal-del{{ $item->id }}"
                            >
                                Verwijder
                            </button>
                            @component('components.confirm-modal', ['uid' => 'del'.$item->id, 'url' => route('opening-datetime.delete', ['openingDatetime' => $item->id]), 'message' => 'Verwijder deze datum?'])
                            @endcomponent
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

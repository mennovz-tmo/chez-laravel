@extends('layouts.page')

@section('content')
    <h1 class="display-4 section-title mb-4">Statistieken</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-custom h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="h5 card-title">Reserveringen</h2>
                    <p class="display-6 mb-1">{{ $totalReservations }}</p>
                    <p class="card-text-muted mb-1">Totaal aantal reserveringen</p>
                    <ul class="list-unstyled mb-0">
                        <li>Gasten totaal: <strong>{{ $totalGuests }}</strong></li>
                        <li>Gemiddelde groepsgrootte: <strong>{{ $averagePartySize }}</strong></li>
                        <li>Aankomend: <strong>{{ $upcomingReservations }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="h5 card-title">Openingstijden</h2>
                    <p class="display-6 mb-1">{{ $specialTotal }}</p>
                    <p class="card-text-muted mb-1">Bijzondere dagen ingesteld</p>
                    <ul class="list-unstyled mb-0">
                        <li>Open: <strong>{{ $specialOpen }}</strong></li>
                        <li>Gesloten: <strong>{{ $specialClosed }}</strong></li>
                        <li>Wekelijks open dagen: <strong>{{ $weeklyOpenDays }}/7</strong></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="h5 card-title">Recepten</h2>
                    <p class="display-6 mb-1">{{ $totalRecipes }}</p>
                    <p class="card-text-muted mb-1">Items op de menukaart</p>
                    <ul class="list-unstyled mb-0">
                        <li>Gemiddelde prijs: <strong>€{{ number_format($averagePrice, 2) }}</strong></li>
                        <li>Goedkoopste: <strong>€{{ number_format($minPrice, 2) }}</strong></li>
                        <li>Duurste: <strong>€{{ number_format($maxPrice, 2) }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <x-chart
                id="reservations-per-day"
                title="Reserveringen en gasten per dag (laatste 14 dagen)"
                :labels="$reservationLabels"
                :datasets="[
                    ['label' => 'Reserveringen', 'data' => $reservationsPerDay],
                    ['label' => 'Gasten', 'data' => $guestsPerDay],
                ]"
            />
        </div>
        <div class="col-lg-6">
            <x-chart
                id="arrivals-by-hour"
                title="Aankomsten per uur"
                :labels="$arrivalLabels"
                :datasets="[
                    ['label' => 'Reserveringen', 'data' => $arrivalCounts],
                ]"
            />
        </div>
        <div class="col-lg-6">
            <x-chart
                id="weekly-hours"
                title="Open uren per weekdag"
                :labels="$weeklyHoursLabels"
                :datasets="[
                    ['label' => 'Uren open', 'data' => $weeklyHoursData],
                ]"
            />
        </div>
        <div class="col-lg-6">
            <x-chart
                id="specials-open-closed"
                type="doughnut"
                title="Bijzondere dagen: open vs gesloten"
                :labels="['Open', 'Gesloten']"
                :datasets="[
                    ['label' => 'Dagen', 'data' => [$specialOpen, $specialClosed]],
                ]"
            />
        </div>
        <div class="col-lg-6">
            <x-chart
                id="recipe-prices"
                type="bar"
                title="Prijzen per recept (top 12)"
                :labels="$recipePriceLabels"
                :datasets="[['label' => 'Prijs (€)', 'data' => $recipePriceData]]"
            />
        </div>
        <div class="col-lg-6">
            <x-chart
                id="allergens"
                type="doughnut"
                title="Recepten per allergeen"
                :labels="$allergenLabels"
                :datasets="[
                    ['label' => 'Recepten', 'data' => $allergenData],
                ]"
            />
        </div>
    </div>

    @if (($upcomingSpecials ?? collect())->count() > 0)
        <h2 class="h4 mt-5 mb-3">Aankomende bijzondere openingstijden</h2>
        <div class="card card-custom shadow-sm">
            <ul class="list-group list-group-flush">
                @foreach ($upcomingSpecials as $special)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $special->date->format('d-m-Y') }}</span>
                        <span>
                            @if ($special->open)
                                {{ $special->opening?->format('H:i') }} – {{ $special->closing?->format('H:i') }}
                            @else
                                Gesloten
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

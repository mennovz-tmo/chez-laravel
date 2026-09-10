<x-mail::message>
# Reservering ontvangen

Hallo {{ $reservation->name }},

Dankjewel voor de reservering!

Je hebt gereserveerd onder de naam {{ $reservation->name }} voor {{ $reservation->amount_of_people }} personen. De datum voor je reservering is {{ $reservation->date->format('d-m-Y') }} om {{ $reservation->arrival }} uur.

Het opgegeven telefoon nummer is {{ $reservation->phone_number }}, dit gebruiken wij alleen om je te bereiken als er een belangrijke mededeling is.

@if($reservation->comment)
En als laatste is de opmerking bij de reservering: <br>
{{ $reservation->comment }}
@endif

Mocht er toch nog iets zijn kunt u ons altijd bellen op 06 12345678.
Of mailen naar contact@chezlaravel.com

<x-mail::button :url="url('/reservation/'.$reservation->id.'/view')">
Bekijk reservering
</x-mail::button>

Met vriendelijke groet, <br>
{{ config('app.name') }}
</x-mail::message>
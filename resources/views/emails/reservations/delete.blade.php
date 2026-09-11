<x-mail::message>
    # Verwijdering bevestigen

    Hallo {{ $reservation->name }},

    De aanvraag om je reservering te verwijderen is hier!

    Je hebt gereserveerd onder de naam {{ $reservation->name }} voor {{ $reservation->amount_of_people }} personen. De
    datum voor je reservering is {{ $reservation->date->format('d-m-Y') }} om {{ $reservation->arrival }} uur.

    Klik op de knop hieronder om het verwijderen te bevestigen. De link is 24 uur geldig. Heb je dit niet zelf
    aangevraagd, dan hoef je niks te doen en blijft je reservering gewoon staan.

    <x-mail::button :url="$deleteUrl">
        Bevestig verwijdering
    </x-mail::button>

    Mocht er toch nog iets zijn kunt u ons altijd bellen op 06 12345678.
    Of mailen naar contact@chezlaravel.com

    Met vriendelijke groet, <br>
    {{ config('app.name') }}
</x-mail::message>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet"
    />
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 40px 44px;
            background-color: #f9f6f1;
            color: #3e2723;
            font-family:
                'DM Sans',
                system-ui,
                -apple-system,
                sans-serif;
            font-weight: 300;
            font-size: 13px;
            letter-spacing: 0.01em;
        }
        .brand {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 600;
            font-size: 28px;
            letter-spacing: -0.02em;
            color: #3e2723;
            margin: 0;
        }
        .tagline {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-style: italic;
            font-size: 16px;
            color: #8b5a3c;
            margin: 2px 0 0 0;
        }
        .brand-row {
            display: table;
            width: 100%;
        }
        .brand-left {
            display: table-cell;
            vertical-align: middle;
        }
        .brand-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            font-size: 11px;
            color: #a1887f;
            text-transform: lowercase;
            letter-spacing: 0.08em;
        }
        .hero {
            margin-top: 18px;
            background: linear-gradient(135deg, #8b5a3c 0%, #6b3a2a 100%);
            border-radius: 4px;
            color: #f5f0e8;
            padding: 22px 26px;
        }
        .hero h1 {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 300;
            font-size: 32px;
            margin: 0;
            letter-spacing: -0.02em;
        }
        .hero p {
            margin: 4px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
        }
        .card {
            margin-top: 20px;
            background-color: #f5f0e8;
            border: 1px solid #d7ccc8;
            border-radius: 8px;
            padding: 24px 26px;
        }
        .card-name {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 600;
            font-size: 22px;
            margin: 0 0 4px 0;
            color: #3e2723;
        }
        .card-sub {
            font-size: 11px;
            color: #a1887f;
            margin: 0 0 16px 0;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 7px 0;
            border-top: 1px solid #d7ccc8;
            vertical-align: top;
            font-size: 13px;
        }
        .details tr:first-child td {
            border-top: none;
        }
        .label {
            width: 38%;
            color: #a1887f;
            font-size: 11px;
            text-transform: lowercase;
            letter-spacing: 0.08em;
        }
        .value {
            color: #3e2723;
            font-weight: 400;
        }
        .number-box {
            margin-top: 16px;
            border: 1px dashed #8b5a3c;
            border-radius: 4px;
            padding: 12px 14px;
            background: #f9f6f1;
        }
        .number-label {
            font-size: 11px;
            color: #8b5a3c;
            text-transform: lowercase;
            letter-spacing: 0.08em;
            margin: 0;
        }
        .number-value {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.12em;
            margin: 2px 0 0 0;
            color: #3e2723;
        }
        .comment {
            margin-top: 14px;
            font-size: 12px;
        }
        .comment strong {
            font-weight: 500;
        }
        .footer {
            margin-top: 22px;
            padding-top: 12px;
            border-top: 1px solid #d7ccc8;
            font-family: 'Cormorant Garamond', Georgia, serif;
            color: #a1887f;
            font-size: 11px;
            text-align: center;
        }
        .footer-note {
            font-family: 'DM Sans', sans-serif;
            font-size: 10px;
            color: #a1887f;
            text-align: center;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    @php
        $arrivalParts = explode(':', (string) $reservation->arrival);
        $arrivalFormatted = count($arrivalParts) >= 2 ? "{$arrivalParts[0]}:{$arrivalParts[1]}" : $reservation->arrival;
        $reservationDate = $reservation->date instanceof \DateTimeInterface
            ? \Illuminate\Support\Carbon::parse($reservation->date)->format('d-m-Y')
            : $reservation->date;
    @endphp
    <div class="brand-row">
        <div class="brand-left">
            <p class="brand">Chez Laravel</p>
            <p class="tagline">Burgers sinds 1974. simpel, eerlijk, met de hand gemaakt.</p>
        </div>
        <div class="brand-right">reserverings-<br />bevestiging</div>
    </div>

    <div class="hero">
        <h1>Reservering details</h1>
        <p>Neem deze bevestiging mee naar het restaurant.</p>
    </div>

    <div class="card">
        <p class="card-name">{{ $reservation->name }}</p>
        <p class="card-sub">
            Gemaakt op {{ $reservation->created_at }} &middot; {{ $reservation->amount_of_people }} {{ $reservation->amount_of_people == 1 ? 'persoon' : 'personen' }}
        </p>

        <table class="details">
            <tr>
                <td class="label">personen</td>
                <td class="value">{{ $reservation->amount_of_people }}</td>
            </tr>
            <tr>
                <td class="label">datum</td>
                <td class="value">{{ $reservationDate }}</td>
            </tr>
            <tr>
                <td class="label">tijd</td>
                <td class="value">{{ $arrivalFormatted }}</td>
            </tr>
            <tr>
                <td class="label">email</td>
                <td class="value">{{ $reservation->email }}</td>
            </tr>
            <tr>
                <td class="label">telefoon</td>
                <td class="value">{{ $reservation->phone_number }}</td>
            </tr>
        </table>

        <div class="number-box">
            <p class="number-label">reserveringsnummer</p>
            <p class="number-value">{{ $reservation->number }}</p>
        </div>

        @if ($reservation->comment)
            <p class="comment"><strong>Opmerking:</strong> {{ $reservation->comment }}</p>
        @endif
    </div>

    <div class="footer">&copy; Chez Laravel Est. 1974</div>
    <div class="footer-note">
        Annuleren of wijzigen kan tot 12 uur voor de reservering. Toon je reserveringsnummer bij aankomst.
    </div>
</body>
</html>

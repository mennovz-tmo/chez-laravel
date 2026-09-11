<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-meta description="Chez Laravel - Burger Restaurant" />
    <title>Chez Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <style>
        :root {
            --earth-dark: #3E2723;
            --earth-main: #6D4C41;
            --earth-mid: #A1887F;
            --earth-light: #D7CCC8;
            --earth-cream: #F5F0E8;
            --earth-paper: #F9F6F1;
            --earth-rust: #8B5A3C;
            --earth-rust-deep: #6B3A2A;
        }

        body {
            background-color: var(--earth-paper);
            color: var(--earth-dark);
            font-family: 'DM Sans', system-ui, sans-serif;
            font-weight: 300;
            letter-spacing: 0.01em;
        }

        h1, h2, h3, h4, h5, h6, .display-1, .display-2, .display-3 {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 600;
            color: var(--earth-dark);
            letter-spacing: -0.02em;
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1.6rem;
            color: var(--earth-dark) !important;
        }

        .nav-link {
            font-family: 'DM Sans', sans-serif;
            text-transform: lowercase;
            font-weight: 400;
            color: var(--earth-dark);
        }

        .nav-link:hover {
            color: var(--earth-rust);
        }

        .btn {
            border-radius: 2px;
            text-transform: lowercase;
            letter-spacing: 0.08em;
            font-weight: 400;
        }

        .btn-primary {
            background-color: var(--earth-rust);
            border-color: var(--earth-rust);
        }

        .btn-primary:hover {
            background-color: var(--earth-rust-deep);
            border-color: var(--earth-rust-deep);
        }

        .btn-outline-dark {
            border-color: var(--earth-dark);
            color: var(--earth-dark);
        }

        .card {
            background-color: var(--earth-cream);
            border: 1px solid var(--earth-light);
            border-radius: 4px;
        }

        a {
            color: var(--earth-rust);
        }

        .dropdown-item:focus,
        .dropdown-item:hover,
        .dropdown-item.active,
        .dropdown-item:active {
            background-color: var(--earth-rust);
            color: #fff;
        }
    </style>
</head>

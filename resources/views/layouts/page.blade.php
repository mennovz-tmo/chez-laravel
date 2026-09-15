<!DOCTYPE html>
<html lang="nl">

@include('components.head')

<body class="d-flex flex-column min-vh-100">
    <header>
        @include('components.nav')
    </header>

    <main class="container py-5 flex-grow-1">
        @include('components.error')

        @yield('content')
    </main>

    <footer class="text-center py-4 mt-auto footer-text">
        &copy; Chez Laravel Est. 1974
    </footer>
</body>

</html>
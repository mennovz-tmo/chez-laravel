<!DOCTYPE html>
<html lang="nl">
@include('components.head')

<body class="d-flex flex-column min-vh-100">
    <header>
        @include('components.nav')
    </header>

    <main class="container flex-grow-1 py-5">
        @include('components.error')

        @yield('content')
    </main>

    <footer class="footer-text mt-auto py-4 text-center">&copy; Chez Laravel Est. 1974</footer>
</body>
</html>

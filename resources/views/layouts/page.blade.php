<!DOCTYPE html>
<html lang="nl">

@include('components.head')

<body class="d-flex flex-column min-vh-100">
    <header>
        @include('components.nav')
    </header>

    <main class="container py-5 flex-grow-1">
        @if ($errors->any())
            <div class="m-2 alert alert-danger alert-danger-custom">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (Session::has('success'))
            <div class="m-2 alert alert-success alert-success-custom">
                {{ Session::get('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center py-4 mt-auto footer-text">
        &copy; Chez Laravel Est. 1974
    </footer>
</body>

</html>
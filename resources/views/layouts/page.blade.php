<!DOCTYPE html>
<html lang="nl">

@include('components.head')

<body class="d-flex flex-column min-vh-100">
    <header>
        @include('components.nav')
    </header>

    <main class="container py-5 flex-grow-1">
        @if ($errors->any())
            <div class="m-2 alert alert-danger" style="background:#f8d7da;border-color:#a1887f;color:#3e2723;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (Session::has('success'))
            <div class="m-2 alert alert-success" style="background:#e8f5e9;border-color:#8b5a3c;color:#3e2723;">
                {{ Session::get('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center py-4 mt-auto"
        style="border-top:1px solid var(--earth-light);font-family:'Cormorant Garamond',serif;color:var(--earth-mid);font-size:0.9rem;">
        &copy; Chez Laravel Est. 1974
    </footer>
</body>

</html>
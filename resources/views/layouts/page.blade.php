<!DOCTYPE html>
<html lang="nl">

@include('components.head')

<body class="d-flex flex-column h-100">
    @include('components.nav')

    <main class="container flex-shrink-0">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="grid content">
            @yield('content')
        </div>
    </main>
</body>

</html>
<!DOCTYPE html>
<html lang="nl">

@include('components.head')

<body class="d-flex flex-column h-100">
    @include('components.nav')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <main class="container flex-shrink-0">
        <div class="grid">
            @yield('content')
        </div>
    </main>
</body>

</html>

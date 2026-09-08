<!DOCTYPE html>
<html lang="nl">

@include('components.head')

<body class="d-flex flex-column h-100">
    @include('components.nav')

    <div class="container">
        @if ($errors->any())
            <div class="m-2 alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (Session::has('success'))
            <div class="m-2 alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
    </div>

    <main class="container grid">
        @yield('content')
    </main>
</body>

</html>
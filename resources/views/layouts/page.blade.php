<!DOCTYPE html>
<html lang="nl">

@extends('components.head')

<body class="d-flex flex-column h-100">
    @yield('nav')

    <main class="container flex-shrink-0">
        <div class="grid text-center">
            @yield('content')
        </div>
    </main>
</body>

</html>

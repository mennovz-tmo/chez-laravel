<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Chez Laravel Burgers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/menu">menu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        reservering opties
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/reservation">reservering maken</a></li>
                        <li><a class="dropdown-item" href="/reservation/view">reservering bekijken</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        administratie
                    </a>
                    <ul class="dropdown-menu">
                        @auth
                            <li><a class="dropdown-item" href="/admin/recipe/add">recept toevoegen</a></li>
                            <li><a class="dropdown-item" href="/reservation/view">Reserveringen beheren</a></li>
                            <li><a class="dropdown-item" href="/admin/auth/logout">uitloggen</a></li>
                        @else
                            <li><a class="dropdown-item" href="/admin/auth/login">inloggen</a></li>
                        @endauth
                    </ul>
                </li>
            </ul>
            {{-- <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> --}}
        </div>
    </div>
</nav>

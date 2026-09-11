<nav class="navbar navbar-expand-lg bg-transparent border-0 py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Chez Laravel</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="box-shadow:none;">
            <span class="navbar-toggler-icon" style="filter:invert(20%) sepia(40%) saturate(50%) hue-rotate(5deg);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-4">
                <li class="nav-item"><a class="nav-link" href="/">start</a></li>
                <li class="nav-item"><a class="nav-link" href="/menu">menukaart</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">reserveren</a>
                    <ul class="dropdown-menu border-0 shadow-sm" style="background:var(--earth-cream);">
                        <li><a class="dropdown-item" href="/reservation/create" style="color:var(--earth-dark);">reservering maken</a></li>
                        <li><a class="dropdown-item" href="/reservation" style="color:var(--earth-dark);">reservering bekijken</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">beheer</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" style="background:var(--earth-cream);">
                        @auth
                            <li><a class="dropdown-item" href="/recipe" style="color:var(--earth-dark);">recept toevoegen</a></li>
                            <li><a class="dropdown-item" href="/menu" style="color:var(--earth-dark);">recepten beheren</a></li>
                            <li><hr class="dropdown-divider" style="border-color:var(--earth-light);"></li>
                            <li><a class="dropdown-item" href="/reservation" style="color:var(--earth-dark);">reserveringen</a></li>
                            <li><hr class="dropdown-divider" style="border-color:var(--earth-light);"></li>
                            <li><a class="dropdown-item" href="/auth/logout" style="color:var(--earth-dark);">uitloggen</a></li>
                        @else
                            <li><a class="dropdown-item" href="/auth/login" style="color:var(--earth-dark);">inloggen</a></li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

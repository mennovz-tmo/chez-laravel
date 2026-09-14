<nav class="navbar navbar-expand-lg bg-transparent border-0 py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Chez Laravel</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation" class="nav-toggler">
            <span class="navbar-toggler-icon nav-icon-filter"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-4">
                <li class="nav-item"><a class="nav-link" href="/">start</a></li>
                <li class="nav-item"><a class="nav-link" href="/menu">menukaart</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">reserveren</a>
                    <ul class="dropdown-menu border-0 shadow-sm dropdown-menu-custom">
                        <li><a class="dropdown-item" href="/reservation/create" class="dropdown-link">reservering maken</a></li>
                        <li><a class="dropdown-item" href="/reservation" class="dropdown-link">reservering bekijken</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">beheer</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm dropdown-menu-custom">
                        @auth
                            <li><a class="dropdown-item" href="/recipe" class="dropdown-link">recept toevoegen</a></li>
                            <li><a class="dropdown-item" href="/menu" class="dropdown-link">recepten beheren</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider dropdown-divider-custom">
                            </li>
                            <li><a class="dropdown-item" href="/reservation" class="dropdown-link">reserveringen</a></li>
                            <li>
                                <hr class="dropdown-divider dropdown-divider-custom">
                            </li>
                            <li><a class="dropdown-item" href="/opening-datetime" class="dropdown-link">openingstijden</a></li>
                            <li>
                                <hr class="dropdown-divider dropdown-divider-custom">
                            </li>
                            <li><a class="dropdown-item" href="/auth/logout" class="dropdown-link">uitloggen</a>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="/auth/login" class="dropdown-link">inloggen</a>
                            </li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
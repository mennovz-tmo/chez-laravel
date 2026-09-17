<nav class="navbar navbar-expand-lg bg-transparent border-0 py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('welcome') }}">Chez Laravel</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation" class="nav-toggler">
            <span class="navbar-toggler-icon nav-icon-filter"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-4">
                <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}">start</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">menukaart</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">reserveren</a>
                    <ul class="dropdown-menu border-0 shadow-sm dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="{{ route('reservation.create') }}" class="dropdown-link">
                                reservering maken
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('reservation.view') }}" class="dropdown-link">
                                reservering bekijken
                            </a>
                        </li>
                    </ul>
                </li>
                @if (isStaff())
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">beheer</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="{{ route('recipe.create') }}" class="dropdown-link">
                                recept toevoegen
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('menu') }}" class="dropdown-link">
                                recepten beheren
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider dropdown-divider-custom">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('reservation.view') }}" class="dropdown-link">
                                reserveringen
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider dropdown-divider-custom">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('opening-datetime.view') }}" class="dropdown-link">
                                openingstijden
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider dropdown-divider-custom">
                        </li>
                        @if (isOwner())
                            <li>
                                <a class="dropdown-item" href="{{ route('manage.users.view') }}" class="dropdown-link">
                                    gebruikers beheren
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider dropdown-divider-custom">
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" class="dropdown-link">
                                uitloggen
                            </a>
                        </li>
                    </ul>
                @elseif (Auth::check() && !isStaff())
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">uitloggen</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Inloggen</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
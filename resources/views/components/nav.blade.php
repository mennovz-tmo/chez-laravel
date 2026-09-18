<nav class="navbar navbar-expand-lg border-0 bg-transparent py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('welcome') }}">Chez Laravel</a>
        <button
            class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            class="nav-toggler"
        >
            <span class="navbar-toggler-icon nav-icon-filter"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-lg-0 gap-lg-4 ms-auto mb-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}">start</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">menukaart</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">reserveren</a>
                    <ul class="dropdown-menu dropdown-menu-custom border-0 shadow-sm">
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
                @if (is_staff())
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">beheer</a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom border-0 shadow-sm">
                        <li>
                            <a class="dropdown-item" href="{{ route('recipe.create') }}"> recept toevoegen </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('menu') }}"> recepten beheren </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider dropdown-divider-custom" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('reservation.view') }}"> reserveringen </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider dropdown-divider-custom" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('opening-datetime.view') }}"> openingstijden </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider dropdown-divider-custom" />
                        </li>
                        @if (is_owner())
                            <li>
                                <a class="dropdown-item" href="{{ route('manage.users.view') }}">
                                    gebruikers beheren
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider dropdown-divider-custom" />
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="{{ route('statistics') }}">statistieken</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider dropdown-divider-custom" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"> uitloggen </a>
                        </li>
                    </ul>
                @elseif (Auth::check() && ! is_staff())
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">uitloggen</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Inloggen</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

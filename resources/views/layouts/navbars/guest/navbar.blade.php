<div class="position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                <div class="container-fluid d-flex justify-content-between align-items-center px-3">

                    <!-- Logo e Título -->
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                        <img src="/img/logo.svg" alt="{{ __('Logo Thoth') }}" width="25" height="35">
                        <h1 class="title-thoth ms-2 mb-0">{{ __('Thoth') }}</h1>
                    </a>

                    <!-- Botão responsivo -->
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>

                    <!-- Links de navegação -->
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav mx-auto d-flex align-items-center justify-content-center">

                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center me-1 active" href="{{ route('home') }}">
                                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.home') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center me-1 active" href="{{ route('about') }}">
                                    <i class="ni ni-bulb-61 opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.about') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center me-1 active" href="{{ route('help') }}">
                                    <i class="ni ni-satisfied opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.help') }}
                                </a>
                            </li>

                            @guest
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-1" href="{{ route('register') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        {{ __('nav/nav.sign_up') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-1" href="{{ route('login') }}">
                                        <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                        {{ __('nav/nav.sign_in') }}
                                    </a>
                                </li>
                            @endguest

                            @auth
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-1" href="{{ route('profile') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        {{ __('nav/nav.profile') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-1" href="{{ route('projects.index') }}">
                                        <i class="ni ni-single-copy-04 opacity-6 text-dark me-1"></i>
                                        {{ __('nav/nav.projects') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a class="nav-link d-flex align-items-center me-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-user opacity-6 text-dark me-1"></i>
                                            <span class="d-sm-inline d-none">{{ __('nav/nav.logout') }}</span>
                                        </a>
                                    </form>
                                </li>
                            @endauth

                            <!-- Dropdown Idioma -->
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdownMenuLink2"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <i class="fas fa-globe me-1"></i>
                                    {{ __("nav/nav.language") }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink2">
                                    <li><a class="dropdown-item" href="{{ route('localization', 'en') }}">English</a></li>
                                    <li><a class="dropdown-item" href="{{ route('localization', 'pt_BR') }}">Português (Brasil)</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>

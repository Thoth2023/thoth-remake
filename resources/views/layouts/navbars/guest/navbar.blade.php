<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="{{ route('home') }}">
                        <img src="/img/logo.svg" alt="{{ __('Logo Thoth') }}" width="25" height="35" />
                    </a>
                    <h1 class="title-thoth">{{ __('Thoth') }}</h1>
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <!-- FIX: Campo de busca com largura ajustada -->
                        <div class="d-flex align-items-center ms-auto me-3" style="max-width: 250px; width: 100%;">
                            <form action="/search-project" method="get" class="w-100">
                                <div class="input-group">
                                    <span class="input-group-text text-body">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" name="searchProject" class="form-control" placeholder="Pesquisar no Thoth...">
                                </div>
                            </form>
                        </div>

                        <ul class="navbar-nav d-flex align-items-center justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center me-1 active" aria-current="page" href="{{ route('home') }}">
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
                                    <a class="nav-link d-flex align-items-center justify-content-center me-1" href="{{ route('register') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        {{ __('nav/nav.sign_up') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center justify-content-center me-1" href="{{ route('login') }}">
                                        <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                        {{ __('nav/nav.sign_in') }}
                                    </a>
                                </li>
                            @endguest

                            @auth
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center justify-content-center" href="{{ route('profile') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        {{ __('nav/nav.profile') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center justify-content-center" href="{{ route('projects.index') }}">
                                        <i class="text-dark text-sm opacity-6 ni ni-single-copy-04 me-1"></i>
                                        {{ __('nav/nav.projects') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link d-flex align-items-center justify-content-center me-1">
                                            <i class="fa fa-user opacity-6 me-1"></i>
                                            <span class="d-sm-inline d-none">
                                                {{ __('nav/nav.logout') }}
                                            </span>
                                        </a>
                                    </form>
                                </li>
                            @endauth
                        </ul>

                        <!-- Language Selector Dropdown -->
                        <div class="dropdown ms-3">
                            <a href="#" class="btn btn-secondary dropdown-toggle mb-0" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                                {{ __('nav/nav.language') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                <li><a class="dropdown-item" href="{{ route('localization', 'en') }}">English</a></li>
                                <li><a class="dropdown-item" href="{{ route('localization', 'pt_BR') }}">Português (Brasil)</a></li>
                            </ul>
                        </div>
                        <!-- End Language Selector Dropdown -->
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>

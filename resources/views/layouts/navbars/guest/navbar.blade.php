<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-fixed start-0 end-0">
                <div class="container">
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

                    <!-- Itens do menu (colapsáveis) -->
                    <div class="collapse navbar-collapse" id="navigation">

                        <ul class="navbar-nav d-flex align-items-center ms-auto">
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" aria-current="page" href="{{ route('home') }}">
                                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.home') }}
                                </a>
                            </li>

                            <!-- Link para página Sobre -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('about') }}">
                                    <i class="ni ni-bulb-61 opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.about') }}
                                </a>
                            </li>

                            <!-- Link para página de Ajuda -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('help') }}">
                                    <i class="ni ni-satisfied opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.help') }}
                                </a>
                            </li>
                            <!-- Se o usuário NÃO estiver autenticado -->
                            @guest
                            <!-- Link para Cadastro -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('register') }}">
                                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.sign_up') }}
                                </a>
                            </li>
                            <!-- Link para Login -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.sign_in') }}
                                </a>
                            </li>
                            @endguest

                            <!-- Se o usuário estiver autenticado -->
                            @auth
                            <!-- Link para Perfil -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('profile') }}">
                                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                    {{ __('nav/nav.profile') }}
                                </a>
                            </li>

                            <!-- Link para Projetos -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('projects.index') }}">
                                    <i class="text-dark text-sm opacity-6 ni ni-single-copy-04 me-1"></i>
                                    {{ __('nav/nav.projects') }}
                                </a>
                            </li>

                            <!-- Link para Deslogar -->
                            <li class="nav-item me-1">
                                <form method="POST" action="{{ route('logout') }}" class="m-1 d-flex align-items-center">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-link nav-link d-flex align-items-center p-0 m-1 text-decoration-none"
                                        style="cursor: pointer;">
                                        <i class="fa fa-sign-out-alt opacity-6 me-1"></i>
                                        <span>{{ __('nav/nav.logout') }}</span>
                                    </button>
                                </form>
                            </li>
                            @endauth

                            <!-- Dropdown de idiomas -->
                            <div class="dropdown">
                                <a href="#" class="btn btn-outline-darker dropdown-toggle mb-0" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                                    <i class="fas fa-globe opacity-6 text-dark me-1" style="color: #000000 !important"></i>
                                    {{ __('nav/nav.language') }} <!-- Texto do idioma atual -->
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                    <!-- Opção: Inglês -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('localization', 'en') }}">English</a>
                                    </li>
                                    <!-- Opção: Português (Brasil) -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('localization', 'pt_BR') }}">Português (Brasil)</a>
                                    </li>
                                </ul>
                            </div>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

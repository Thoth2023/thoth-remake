<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-fixed start-0 end-0 mx-4">
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

                    <!-- Itens do menu (colapsáveis) -->
                    <div class="collapse navbar-collapse" id="navigation">

                        <ul class="navbar-nav d-flex align-items-center ms-auto">
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" aria-current="page" href="{{ route('home') }}">
                                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                                    {{ translationNav('home') }}
                                </a>
                            </li>

                            <!-- Link para página Sobre -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('about') }}">
                                    <i class="ni ni-bulb-61 opacity-6 text-dark me-1"></i>
                                    {{ translationNav('about') }}
                                </a>
                            </li>

                            <!-- Link para página de Ajuda -->
                            <li class="nav-item me-1">
                                <a class="nav-link d-flex align-items-center" href="{{ route('help') }}">
                                    <i class="ni ni-satisfied opacity-6 text-dark me-1"></i>
                                    {{ translationNav('help') }}
                                </a>
                            </li>

                            <!-- Se o usuário NÃO estiver autenticado -->
                            @guest
                                <!-- Link para Cadastro -->
                                <li class="nav-item me-1">
                                    <a class="nav-link d-flex align-items-center" href="{{ route('register') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        {{ translationNav('sign_up') }}
                                    </a>
                                </li>
                                <!-- Link para Login -->
                                <li class="nav-item me-1">
                                    <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                                        <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                        {{ translationNav('sign_in') }}
                                    </a>
                                </li>
                            @endguest

                            <!-- Se o usuário estiver autenticado -->
                            @auth
                                <!-- Link para Perfil -->
                                <li class="nav-item me-1">
                                    <a class="nav-link d-flex align-items-center" href="{{ route('profile') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        {{ translationNav('profile') }}
                                    </a>
                                </li>

                                <!-- Link para Projetos -->
                                <li class="nav-item me-1">
                                    <a class="nav-link d-flex align-items-center" href="{{ route('projects.index') }}">
                                        <i class="text-dark text-sm opacity-6 ni ni-single-copy-04 me-1"></i>
                                        {{ translationNav('projects') }}
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
                                            <span>{{ translationNav('logout') }}</span>
                                        </button>
                                    </form>
                                </li>
                            @endauth

                            <!-- ✅ Botão de Configuração sempre visível -->
                            <li class="nav-item me-1 d-flex align-items-center">
                                <a href="javascript:;" class="nav-link text-dark p-0 d-flex align-items-center">
                                    <i class="fa fa-cog opacity-6 me-1 fixed-plugin-button-nav cursor-pointer"></i>
                                    <span>{{ translationNav('settings') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

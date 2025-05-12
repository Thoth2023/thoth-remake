<!-- Container principal fixo que abriga o painel flutuante -->
<div class="fixed-plugin">
    <div class="card shadow-lg"> <!-- Cartão com sombra -->

        <!-- Cabeçalho do cartão -->
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">
                <!-- Título do painel (configurador) -->
                <h5 class="mt-3 mb-0">{{ __('nav/side.thoth_configurator') }}</h5>
                <!-- Subtítulo explicativo -->
                <p>{{ __('nav/side.dashboard_options') }}</p>
            </div>

            <!-- Botão de fechar o painel -->
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="fa fa-close"></i> <!-- Ícone de fechar -->
                </button>
            </div>
        </div>

        <!-- Linha horizontal de separação -->
        <hr class="horizontal dark my-1">

        <!-- Corpo do cartão com overflow scroll para conteúdo -->
        <div class="card-body pt-sm-3 pt-0 overflow-auto">

            <!-- Seção de seleção de idioma -->
            <div>
                <h6 class="mb-1">{{ __('nav/side.language_selection') }}</h6>
            </div>

            <!-- Dropdown de idiomas -->
            <div class="dropdown">
                <a href="#" class="btn btn-secondary dropdown-toggle mb-0" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                    <i class="fas fa-globe opacity-6 text-dark me-1" style="color: #FFFFFF !important"></i>
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

            <!-- Seção de seleção de cor da sidebar -->
            <div>
                <h6 class="mb-0 mt-3">{{ __('nav/side.sidebar_color') }}</h6>
            </div>

            <!-- Botões coloridos para trocar a cor da sidebar -->
            <a href="javascript:void(0)" class="switch-trigger background-color">
                <div class="badge-colors my-2 text-start">
                    <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
                </div>
            </a>

            <!-- Tipo de sidebar: clara ou escura -->
            <div class="mt-3">
                <h6 class="mb-0">{{ __('nav/side.sidenav_type') }}</h6>
                <p class="text-sm">{{ __('nav/side.sidenav_choose') }}</p>
            </div>

            <!-- Botões para mudar o tipo de sidebar -->
            <div class="d-flex">
                <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">
                    {{ __('nav/side.white') }}
                </button>
                <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">
                    {{ __('nav/side.dark') }}
                </button>
            </div>

            <!-- Aviso visível apenas em telas menores -->
            <p class="text-sm d-xl-none d-block mt-2">{{ __('nav/side.sidenav_warning') }}</p>

            <!-- Switch para fixar ou não a navbar -->
            <div class="d-flex my-3">
                <h6 class="mb-0">{{ __('nav/side.navbar_fixed') }}</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
                </div>
            </div>

            <!-- Separador -->
            <hr class="horizontal dark my-sm-4">

            <!-- Switch para alternar entre modo claro e escuro -->
            <div class="mt-2 mb-5 d-flex">
                <h6 class="mb-0">{{ __('nav/side.light_dark') }}</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
                </div>
            </div>

            <!-- Botões de links externos (GitHub e site da Lesse) -->
            <div class="w-100 text-center">
                <a href="https://github.com/Thoth2023/thoth2.0" class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-github me-1" aria-hidden="true"></i> Thoth
                </a>
                <a href="https://www.lesse.com.br" class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-laravel me-1" aria-hidden="true"></i> Lesse
                </a>
            </div>

        </div>
    </div>
</div>

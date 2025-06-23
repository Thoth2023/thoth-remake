
<!-- Container principal fixo que abriga o painel flutuante -->
<div class="fixed-plugin">
    <div class="card shadow-lg"> <!-- Cartão com sombra -->

        <!-- Cabeçalho do cartão -->
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">
                <!-- Título do painel (configurador) -->
                <h5 class="mt-3 mb-0">{{ translationSide('thoth_configurator') }}</h5>
                <!-- Subtítulo explicativo -->
                <p>{{ translationSide('dashboard_options') }}</p>
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
                <h6 class="mb-1">{{ translationSide('language_selection') }}</h6>
            </div>

            <!-- Dropdown de idiomas -->
            <div class="dropdown">
                <a href="#" class="btn btn-secondary dropdown-toggle mb-0" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                    <i class="fas fa-globe opacity-6 text-dark me-1" style="color: #FFFFFF !important"></i>
                    {{ translationNav('language') }} <!-- Texto do idioma atual -->
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
                <h6 class="mb-0 mt-3">{{ translationSide('sidebar_color') }}</h6>
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
                <h6 class="mb-0">{{ translationSide('sidenav_type') }}</h6>
                <p class="text-sm">{{ translationSide('sidenav_choose') }}</p>
            </div>

            <!-- Botões para mudar o tipo de sidebar -->
            <div class="d-flex">
                <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">
                    {{ translationSide('white') }}
                </button>
                <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">
                    {{ translationSide('dark') }}
                </button>
            </div>

            <!-- Aviso visível apenas em telas menores -->
            <p class="text-sm d-xl-none d-block mt-2">{{ translationSide('sidenav_warning') }}</p>

            <!-- Switch para fixar ou não a navbar -->
            <div class="d-flex my-3">
                <h6 class="mb-0">{{ translationSide('navbar_fixed') }}</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed">
                </div>
            </div>


            <!-- Separador -->
            <hr class="horizontal dark my-sm-4">

            <!-- Switch para alternar entre modo claro e escuro -->
            <div class="mt-2 mb-5 d-flex">
                <h6 class="mb-0">{{ translationSide('light_dark') }}</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
                </div>
            </div>
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


<!-- Script para persistência do modo escuro/claro -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkbox = document.getElementById('dark-version');
        const savedTheme = localStorage.getItem('theme') || 'light';

        if (savedTheme === 'dark') {
            document.body.classList.add('dark-version');
            checkbox.checked = true;
        } else {
            document.body.classList.remove('dark-version');
            checkbox.checked = false;
        }

        checkbox.addEventListener('change', () => {
            const newTheme = checkbox.checked ? 'dark' : 'light';

            document.body.classList.toggle('dark-version', newTheme === 'dark');
            localStorage.setItem('theme', newTheme);
        });
    });
</script>

<script>
    // Script para persistência do tipo de sidebar
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarButtons = document.querySelectorAll('[onclick="sidebarType(this)"]');
        const savedSidebarType = localStorage.getItem('sidebar-type');

        if (savedSidebarType) {
            document.querySelector('.sidenav').classList.remove('bg-white', 'bg-default');
            document.querySelector('.sidenav').classList.add(savedSidebarType);

            // Atualiza o estado dos botões
            sidebarButtons.forEach(btn => {
                if (btn.dataset.class === savedSidebarType) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }

        sidebarButtons.forEach(button => {
            button.addEventListener('click', () => {
                const sidebar = document.querySelector('.sidenav');
                const newClass = button.dataset.class;

                // Troca a classe no sidebar
                sidebar.classList.remove('bg-white', 'bg-default');
                sidebar.classList.add(newClass);

                // Salva no localStorage
                localStorage.setItem('sidebar-type', newClass);

                // Atualiza botões
                sidebarButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    });
</script>

<script>
    // Script para persistência da cor da sidebar
    document.addEventListener('DOMContentLoaded', () => {
        const colorBadges = document.querySelectorAll('.switch-trigger .badge');
        const savedSidebarColor = localStorage.getItem('sidebar-color');

        if (savedSidebarColor) {
            const sidebar = document.querySelector('.sidenav');
            sidebar.setAttribute('data-color', savedSidebarColor);

            // Atualiza os badges
            colorBadges.forEach(badge => {
                if (badge.dataset.color === savedSidebarColor) {
                    badge.classList.add('active');
                } else {
                    badge.classList.remove('active');
                }
            });
        }

        colorBadges.forEach(badge => {
            badge.addEventListener('click', () => {
                const newColor = badge.dataset.color;
                const sidebar = document.querySelector('.sidenav');

                // Atualiza atributo data-color
                sidebar.setAttribute('data-color', newColor);
                localStorage.setItem('sidebar-color', newColor);

                // Atualiza badges ativos
                colorBadges.forEach(b => b.classList.remove('active'));
                badge.classList.add('active');
            });
        });
    });
</script>

<script>
    // Script para persistência da opção "Navbar Fixed"
    document.addEventListener('DOMContentLoaded', () => {
        const navbarFixedCheckbox = document.getElementById('navbarFixed');
        const savedNavbarFixed = localStorage.getItem('navbar-fixed');

        if (savedNavbarFixed === 'true') {
            navbarFixedCheckbox.checked = true;
            navbarFixed(navbarFixedCheckbox); // ativa o modo fixo
        } else {
            navbarFixedCheckbox.checked = false;
            navbarFixed(navbarFixedCheckbox); // garante que está desativado
        }

        navbarFixedCheckbox.addEventListener('change', () => {
            const isChecked = navbarFixedCheckbox.checked;
            localStorage.setItem('navbar-fixed', isChecked.toString());
            navbarFixed(navbarFixedCheckbox); // aplica mudança visual
        });
    });
</script>

<script>
    //Script para correspondência entre os estilos dos elementos
    document.addEventListener('DOMContentLoaded', () => {
        const checkbox = document.getElementById('dark-version');
        const body = document.body;
        const sidebar = document.querySelector('.sidenav');
        const savedTheme = localStorage.getItem('theme') || 'light';

        function applyTheme(theme) {
            const isDark = theme === 'dark';

            // Modo dark no body
            body.classList.toggle('dark-version', isDark);

            // Altera o tipo da sidebar
            sidebar.classList.remove('bg-white', 'bg-default');
            sidebar.classList.add(isDark ? 'bg-default' : 'bg-white');

            // Atualiza botões de tipo de sidebar
            document.querySelectorAll('[onclick="sidebarType(this)"]').forEach(btn => {
                if (btn.dataset.class === (isDark ? 'bg-default' : 'bg-white')) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Salva preferências
            localStorage.setItem('theme', theme);
            localStorage.setItem('sidebar-type', isDark ? 'bg-default' : 'bg-white');
        }

        // Aplica tema salvo
        applyTheme(savedTheme);
        checkbox.checked = savedTheme === 'dark';

        // Lida com mudança manual
        checkbox.addEventListener('change', () => {
            const newTheme = checkbox.checked ? 'dark' : 'light';
            applyTheme(newTheme);
        });
    });
</script>


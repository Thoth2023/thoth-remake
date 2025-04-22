<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <title>Thoth :: Tool for SLR</title>

        <!-- Ícones e Favicon -->
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

        <!-- Tema para PWA -->
        <meta name="theme-color" content="#c9c5b1" />
        <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}" />
        <link rel="manifest" href="{{ asset('/manifest.json') }}" />

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

        <!-- Estilos do projeto -->
        <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/fontawesome-free-6.6.0-web/css/all.min.css') }}" rel="stylesheet" />
        <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/select.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

        <!-- Ícones Lucide (substitui FontAwesome se quiser algo mais moderno) -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Quill (editor de texto rico) -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

        <!-- Bibliotecas extras -->
        <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @livewireStyles

        <!-- reCAPTCHA no cadastro -->
        @if(request()->is('register'))
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        @endif

        <!-- Estilo personalizado moderno -->
        <style>
            :root {
                --primary-color: #0a84ff;
                --background: #f9f9fa;
                --text-color: #333;
            }

            body {
                background: var(--background);
                color: var(--text-color);
                font-family: 'Open Sans', sans-serif;
            }

            .shadow-box {
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
                border-radius: 16px;
                background: white;
                padding: 1rem;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            textarea {
                width: 100%;
                max-width: 500px;
                padding: 12px;
                border-radius: 12px;
                border: 1px solid #ccc;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                transition: all 0.2s ease-in-out;
            }

            input:focus, textarea:focus {
                border-color: var(--primary-color);
                outline: none;
                box-shadow: 0 0 0 3px rgba(10, 132, 255, 0.2);
            }
        </style>
    </head>

    <body class="g-sidenav-show {{ in_array(request()->route()->getName(), ['login', 'reset-password', 'change-password', 'message']) ? 'bg-white' : 'bg-gray-300' }}">

        @guest
            @yield("content")
        @endguest

        @auth
            @if (in_array(request()->route()->getName(), ['login', 'register', 'reset-password', 'change-password', 'message']))
                @yield("content")
            @else
                @if (!in_array(request()->route()->getName(), ['profile', 'home', 'about', 'help', 'database-manager']))
                    <div class="bg-gradient-faded-dark opacity-8 position-absolute w-100" style="min-height: 280px"></div>
                @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
                    <div class="bg-gradient-faded-dark position-absolute w-100 min-height-300 top-0">
                        <span class="mask bg-primary opacity-8"></span>
                    </div>
                @endif

                @include("layouts.navbars.auth.sidenav")

                <main class="main-content">
                    <div class="container">
                        @yield("content")
                    </div>
                </main>

                @include("components.fixed-plugin")
            @endif
        @endauth

        <!-- Scripts PWA -->
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/pwabuilder-sw.js')
                    .then(reg => console.log('Service Worker registrado:', reg))
                    .catch(err => console.error('Erro no SW:', err));
            }
        </script>

        <!-- Scripts principais -->
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Scroll personalizado -->
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
            }
        </script>

        <!-- Ativar ícones Lucide -->
        <script>
            lucide.createIcons();
        </script>

        <!-- Toasts (mensagens) -->
        <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3" style="z-index: 9999">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Mensagem</strong>
                    <small class="toast-time"></small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body"></div>
            </div>
        </div>
        <!-- Box de Citação do Thoth - Minimalista com laranja queimado e azul escuro -->
<div class="p-5 mt-5 rounded-4 shadow-sm" style="background-color: #1e253b; color: #f5f6fa; border: 1px solid #2e3755;">
    <h4 class="fw-semibold mb-3" style="font-size: 1.5rem; color: #e67e22;">Cite o Thoth em sua pesquisa</h4>
    
    <p class="mb-4" style="color: #c4c8d4; font-size: 0.95rem; max-width: 680px;">
        Se o Thoth foi útil na sua revisão sistemática ou artigo acadêmico, considere citá-lo. Sua citação contribui para o reconhecimento e a continuidade deste projeto na comunidade científica.
    </p>

    <div class="bg-white bg-opacity-10 p-3 rounded-3 mb-4" style="font-style: italic; color: #4a6fa5;">
        Thoth, <cite>Sistema de Apoio a Revisões Sistemáticas</cite>, 2025.
    </div>

    <a href="https://thoth.com/citation" class="text-decoration-none" style="color: #a6b3d0; font-size: 0.9rem;">
        Saiba mais sobre como citar o Thoth →
    </a>
</div>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toast = new bootstrap.Toast(document.querySelector('.toast'));
                const error = "{{ session('error') }}";
                const success = "{{ session('success') }}";

                if (error) {
                    showToast(error, 'Erro');
                } else if (success) {
                    showToast(success, 'Sucesso');
                }

                function showToast(message, type) {
                    document.querySelector('.toast-body').innerText = message;
                    document.querySelector('.toast-header strong').innerText = type;
                    toast.show();
                }
            });
        </script>

        <!-- Scripts adicionais -->
        <script src="{{ asset('assets/js/utils.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>
        <script src="{{ asset('assets/js/cep_autocomplete.js') }}"></script>
        <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
        <script src="{{ asset('resources/js/app.js') }}" defer></script>

        @stack('scripts')
        @livewireScripts
    </body>
</html>

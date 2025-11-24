<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>

    <meta name="google-site-verification" content="_JgfrM1YqlGt4k-n6M-B6rZS8oxIBd8DZzalkiEAEX8" />

    <title>Thoth :: Tool for SLR</title>

    <!-- PWA -->
    <meta name="theme-color" content="#c9c5b1" />
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}"/>
    <link rel="manifest" href="{{ asset('/manifest.json') }}"/>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Nucleo / FontAwesome -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/fontawesome-free-6.6.0-web/css/all.min.css') }}" rel="stylesheet"/>

    <!-- CSS principal do template -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/thoth-mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}"/>

    <!-- Vite (substitui o asset('resources/js/app.js')) -->
    @vite(['resources/js/app.js'])

    <!-- Quill / Choices / SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- reCaptcha somente na rota de registro -->
    @if(request()->is('register'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endif

    @livewireStyles
</head>

<body class="g-sidenav-show {{ in_array(request()->route()->getName(), ['login','reset-password','change-password','message']) ? 'bg-white' : 'bg-gray-300' }}">

@guest
    @include('layouts.navbars.guest.navbar', ['title' => 'Home'])
    @yield('content')
@endguest

@auth
    @if (! in_array(request()->route()->getName(),['profile','home']))
        <div class="bg-gradient-faded-dark opacity-8 position-absolute w-100" style="min-height: 280px"></div>
    @elseif (in_array(request()->route()->getName(),['profile-static','profile']))
        <div class="bg-gradient-faded-dark position-absolute w-100 min-height-300 top-0">
            <span class="mask bg-primary opacity-8"></span>
        </div>
    @endif

    @include('layouts.navbars.auth.sidenav')

    <main class="main-content">
        <div class="container">
            @yield('content')

            {{-- Exibir o chat apenas nas páginas do projeto --}}
            @if (request()->routeIs('projects.show') || str_starts_with(request()->route()->getName(), 'project.'))
                @isset($project)
                    @include('components.chat', ['projeto_id' => $project->id_project])
                @endisset
            @endif
        </div>
    </main>
@endauth

<!-- Fixed plugin -->
@include('components.fixed-plugin')

<!-- Core JS -->
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

<!-- jQuery (se realmente precisar) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
</script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Argon Dashboard -->
<script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>

<!-- Google Maps (async/defer) -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>

<!-- Utils / CEP -->
<script src="{{ asset('assets/js/utils.js') }}"></script>
<script src="{{ asset('assets/js/cep_autocomplete.js') }}"></script>

@stack('js')
@stack('scripts')
@livewireScripts

<!-- Service Worker (uma vez, com caminho absoluto) -->
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/pwabuilder-sw.js')
            .then(reg => console.log('Service worker registration succeeded:', reg.scope))
            .catch(err => console.error('Service worker registration failed:', err));
    }
</script>

@guest
    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3" style="z-index: 9999">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Bootstrap</strong>
                <small class="toast-time"></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastElement = document.getElementById('liveToast');
            const toastBody = toastElement.querySelector('.toast-body');

            function showToast(message, type) {
                toastBody.innerText = message;
                toastElement.querySelector('.toast-header strong').innerText = type;
                new bootstrap.Toast(toastElement).show();
            }

            const errorMessage = @json(session('error'));
            const successMessage = @json(session('success'));

            if (errorMessage) {
                showToast(errorMessage, 'Error');
            } else if (successMessage) {
                showToast(successMessage, 'Success');
            } else {
                @if($errors->any())
                const validationErrors = @json($errors->all());
                showToast(validationErrors.join(' '), 'Error');
                @endif
            }
        });
    </script>
@endguest

@auth
    <script>
        const usuarioLogado = @json(Auth::user()->name);
    </script>
@endauth

</body>
</html>

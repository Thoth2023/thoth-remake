<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset("img/apple-icon.png") }}"
        />
        <link
            rel="icon"
            type="image/png"
            href="{{ asset("img/favicon.png") }}"
        />
        <title>Thoth :: Tool for SLR</title>
        <!-- PWA  -->
        <meta name="theme-color" content="#c9c5b1" />
        <link rel="apple-touch-icon" href="{{ asset("logo.PNG") }}" />
        <link rel="manifest" href="{{ asset("/manifest.json") }}" />

        <!-- Fonts and icons -->
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
            rel="stylesheet"
        />
        <!-- Nucleo Icons -->
        <link
            href="{{ asset("assets/css/nucleo-icons.css") }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset("assets/css/nucleo-svg.css") }}"
            rel="stylesheet"
        />

        <link
            href="{{ asset("assets/css/nucleo-svg.css") }}"
            rel="stylesheet"
        />

        <link
            href="{{ asset("assets/fontawesome-free-6.6.0-web/css/all.min.css") }}"
            rel="stylesheet"
        />

        <!-- CSS Files -->
        <link
            id="pagestyle"
            href="{{ asset("assets/css/argon-dashboard.css") }}"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="{{ asset("assets/css/select.css") }}" />
        <link rel="stylesheet" href="{{ asset("assets/css/styles.css") }}" />

        <!-- Google reCaptcha-->
        @if(request()->is('register'))
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        @endif


        <!--editor de richtexto Quill -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
         @livewireStyles
    </head>

    <body
        class="g-sidenav-show {{ in_array( request()->route()->getName(),["login", "reset-password", "change-password","message"],) ? "bg-white" : "bg-gray-300" }}"
    >
        @guest
            @yield("content")
        @endguest

        @auth
            @if (in_array(request()->route()->getName(),["login", "register", "reset-password", "change-password","message"]))
                @yield("content")
            @else
                @if (! in_array(request()->route()->getName(),["profile", "home", "about", "help", "database-manager"]))
                    <div
                        class="bg-gradient-faded-dark opacity-8 position-absolute w-100"
                        style="min-height: 280px"
                    ></div>
                @elseif (in_array(request()->route()->getName(),["profile-static", "profile"]))
                    <div
                        class="bg-gradient-faded-dark position-absolute w-100 min-height-300 top-0"
                    >
                        >
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

        <!-- PWA service worker -->
        <script>
            if (typeof navigator.serviceWorker !== 'undefined') {
                navigator.serviceWorker.register('pwabuilder-sw.js');
            }
        </script>

        <!-- Core JS Files -->
        <script src="{{ asset("assets/js/core/popper.min.js") }}"></script>
        <script src="{{ asset("assets/js/core/bootstrap.min.js") }}"></script>
        <script src="{{ asset("assets/js/plugins/perfect-scrollbar.min.js") }}"></script>
        <script src="{{ asset("assets/js/plugins/smooth-scrollbar.min.js") }}"></script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5',
                };
                Scrollbar.init(
                    document.querySelector('#sidenav-scrollbar'),
                    options,
                );
            }
        </script>

        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->

        <script src="{{ asset("assets/js/argon-dashboard.js") }}"></script>
        <script src="{{ asset("resources/js/app.js") }}" defer></script>
        @stack("js")

        <script src="{{ asset("/pwabuilder-sw.js") }}"></script>
        <script>
            if ('serviceWorker' in navigator) {
                // Register a service worker hosted at the root of the
                // site using the default scope.
                navigator.serviceWorker.register('/pwabuilder-sw.js').then(
                    (registration) => {
                        console.log(
                            'Service worker registration succeeded:',
                            registration,
                        );
                    },
                    (error) => {
                        console.error(
                            `Service worker registration failed: ${error}`,
                        );
                    },
                );
            } else {
                console.error('Service workers are not supported.');
            }
        </script>

        <div
            class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"
            style="z-index: 9999"
        >
            <div
                id="liveToast"
                class="toast"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
            >
                <div class="toast-header">
                    <strong class="me-auto">Bootstrap</strong>
                    <small class="toast-time"></small>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="toast"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="toast-body"></div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastContainer = document.querySelector('.toast-container');
                const toastElement = toastContainer.querySelector('.toast');
                const toastBody = toastElement.querySelector('.toast-body');
                const toastTime = toastElement.querySelector('.toast-time');

                function decodeHtmlEntities(str) {
                    if (!str) return '';
                    const temp = document.createElement('textarea');
                    temp.innerHTML = str;
                    return temp.value;
                }

                function showToast(message, type) {
                    const decodedMessage = decodeHtmlEntities(message);
                    toastBody.innerText = decodedMessage;
                    toastElement.querySelector('.toast-header strong').innerText = type;
                    const toast = new bootstrap.Toast(toastElement);
                    toast.show();
                }

                // Check if there's an error or success flash message
                const errorMessage = "{{ session('error') }}";
                const successMessage = "{{ session('success') }}";

                if (errorMessage) {
                    showToast(errorMessage, 'Error');
                } else if (successMessage) {
                    showToast(successMessage, 'Success');
                } else {
                    // Check for validation errors
                    @if ($errors->any())
                        const validationErrors = @json($errors->all());
                        showToast(validationErrors.join(' '), 'Error');
                    @endif
                }
            });
        </script>



        {{-- Search input js logic --}}
        <script src="{{ asset("assets/js/utils.js") }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_API_KEY") }}&libraries=places"></script>
        <script src="{{ asset("assets/js/cep_autocomplete.js") }}"></script>
        @stack("scripts")
        @livewireScripts
    </body>
</html>

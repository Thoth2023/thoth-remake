<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
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
        <!-- Font Awesome Icons -->
        <script
            src="https://kit.fontawesome.com/42d5adcbca.js"
            crossorigin="anonymous"
        ></script>
        <link
            href="{{ asset("assets/css/nucleo-svg.css") }}"
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
        <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    </head>

    <body class="g-sidenav-show {{ in_array(request()->route()->getName(),["login", "register", "recover-password"]) ? 'bg-white' : 'bg-gray-300' }}">
        @guest
            @yield("content")
        @endguest

        @auth
            @if (in_array(request()->route()->getName(),["login", "register", "recover-password"]))
                @yield("content")
            @else
                @if (! in_array(request()->route()->getName(),["profile", "home"]))
                    <div
                        class="bg-primary position-absolute w-100"
                        style="min-height: 140px;"
                    ></div>
                @elseif (in_array(request()->route()->getName(),["profile-static", "profile"]))
                    <div
                        class="position-absolute w-100 min-height-300 top-0"
                        style="
                            background-image: url('{{ asset("https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg") }}');
                            background-position-y: 50%;
                        "
                    >
                        <span class="mask bg-primary opacity-6"></span>
                    </div>
                @endif
                @include("layouts.navbars.auth.sidenav")
                <main class="main-content">
                    @yield("content")
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

                function showToast(message, type) {
                    toastBody.innerText = message;
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
                        showToast(validationErrors.join(', '), 'Error');
                    @endif
                }

            });
        </script>

        {{-- Search input js logic --}}
        <script src="{{ asset("assets/js/utils.js") }}"></script>

        @stack("scripts")
    </body>
</html>

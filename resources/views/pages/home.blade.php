@extends("layouts.app")


@section("content")
@include("layouts.navbars.guest.navbar", ["title" => __("pages/home.home")])

<div class="container mt-2">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<!-- Displays a page with a header, description, and a dynamic grid of cards with icons and translated text -->
<div  class="container mt-6 mb-3">
    <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style="width: 100%">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">
                    {{ __("pages/home.welcome") }}
                </h1>
                <p class="text-lead text-white">
                    {{ __("pages/home.thoth_description") }}
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">

            <div class="grid-items-2 gap-3 card-group mt-5 pb-3">
                @foreach ([
                "questions" => "ni ni-bullet-list-67",
                "relevant_data" => "ni ni-single-copy-04",
                "quality" => "ni ni-like-2",
                "analyse_data" => "ni ni-chart-bar-32"
                ] as $key => $icon)
                <div class="card rounded-3 p-3 d-flex flex-column h-100">
                    <div class="card-body pt-2 d-flex flex-column">
                        <span href="#" onclick="event.preventDefault();" class="card-title h5 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                            <i class="{{ $icon }}"></i>
                            {{ __("pages/home." . $key) }}
                        </span>
                        <p class="card-description mb-4">
                            {{ __("pages/home." . $key . "_description") }}
                        </p>
                        <div class="mt-auto"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

	<!-- Row displaying four statistics cards: total projects, total users, completed projects, and ongoing projects -->
    <div class="row mt-2">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <span href="#" onclick="event.preventDefault();" style="cursor: default; transition: color 0.2s;">
                        <i class="fas fa-project-diagram fa-2x mb-2"></i>
                        <h2 class="h2 card-title mt-auto"><span id="project-count">0</span></h2>
                        <h6 class="h6 card-text">{{ __("pages/home.total_projects") }} </h6>
                    </span>

                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <span href="#" onclick="event.preventDefault();" style="cursor: default; transition: color 0.2s;">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h2 id="user-count" class="card-title mt-auto"><span>0</span></h2>
                        <h6 class="card-text">{{ __("pages/home.total_users") }}</h6>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <span href="#" onclick="event.preventDefault();" style="cursor: default; transition: color 0.2s;">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h2 id="total-finished-projects-count" class="card-title mt-auto"><span>0</span></h2>
                        <h6 class="card-text">{{ __("pages/home.completed_projects") }}</h6>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <span href="#" onclick="event.preventDefault();" style="cursor: default; transition: color 0.2s;">
                        <i class="fas fa-spinner fa-2x mb-2"></i>
                        <h2 id="total-ongoing-projects-count" class="card-title mt-auto"><span>0</span></h2>
                        <h6 class="card-text">{{ __("pages/home.ongoing_projects") }}</h6>
                    </span>
                </div>
            </div>
        </div>

        <!-- Novidades IEEE -->

            <div class="col-12 mt-2">
                <div class="card p-4" style="background: #0D1B34; color: #fff">
                    <h5 class="mb-4" style="color: #FFA500; font-size: 1.7rem">
                        Novidades IEEE
                    </h5>

                    <ul class="list-group list-group-flush p-0">
                        <li class="list-group-item" style="background: #0D1B34; color: #fff">
                            <a href="#" style="color: #fff; font-size: 1.2rem">
                                IEEE lança nova revista focada em Inteligência Artificial
                            </a>
                        </li>
                        <li class="list-group-item" style="background: #0D1B34; color: #fff">
                            <a href="#" style="color: #fff; font-size: 1.2rem">
                                Aplicação de redes neurais na robótica autônoma
                            </a>
                        </li>
                        <li class="list-group-item" style="background: #0D1B34; color: #fff">
                            <a href="#" style="color: #fff; font-size: 1.2rem">
                                5 caminhos para a computação quântica nas empresas
                            </a>
                        </li>
                        <li class="list-group-item" style="background: #0D1B34; color: #fff">
                            <a href="#" style="color: #fff; font-size: 1.2rem">
                                Cibersegurança na era da Internet das Coisas
                            </a>
                        </li>
                    </ul>

                    <a
                        href="https://www.ieee.org/"
                        target="_blank"
                        class="btn mt-4"
                        style="background: #FFA500; color: #fff">
                        Veja mais no IEEE
                    </a>
                </div>
            </div>


        <!-- Rodapé com links para Termos e Política de Privacidade e para o topo da página -->
        <div class="col-12 mt-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <!-- Nome do site e direitos autorais -->
                    <p class="mb-0 text-muted">
                        © {{ date('Y') }} - Thoth :: Tool for SLR
                    </p>

                    <!-- Termos e Voltar ao Topo -->
                    <div class="d-flex gap-3">
                        <a href="{{ url('/terms') }}" class="text-muted">
                            <i class="fas fa-user-shield me-1"></i>
                            {{ __("pages/home.terms_and_conditions") }}
                        </a>

                        <a href="#top" class="text-muted d-flex align-items-center">
                            <span>{{ __("pages/home.back-top") }} </span>
                            <i class="fas fa-arrow-up ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection


@push("js")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
        const totalUsers = {{ $total_users }};
        const totalProjects = {{ $total_projects }};
        const totalFinishedProjects = {{ $total_finished_projects }};
        const totalOngoingProjects = {{ $total_ongoing_projects }};

		// Function to animate the value from start to end
        function animateValue(id, start, end, duration) {
            const range = end - start;
            let current = start;
            const increment = end > start ? 1 : -1;
            const startTime = new Date().getTime();
            const endTime = startTime + duration;
            const stepTime = Math.abs(Math.floor(duration / range));

            const timer = setInterval(function() {
                const now = new Date().getTime();
                const remaining = Math.max((endTime - now) / duration, 0);
                current = Math.round(end - (remaining * range));
                $('#' + id).text(current);

                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

		// Function to check if the element is in the viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

		// Function to animate the value when the element is visible
        function animateIfVisible(id, value) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        animateValue(id, 0, value, 2000);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            const target = document.getElementById(id);
            observer.observe(target);
        }

		// Animate the values when the elements are visible
        animateIfVisible('user-count', totalUsers);
        animateIfVisible('project-count', totalProjects);
        animateIfVisible('total-finished-projects-count', totalFinishedProjects);
        animateIfVisible('total-ongoing-projects-count', totalOngoingProjects);
    });
    </script>
@endpush

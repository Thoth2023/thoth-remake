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

<div  class="container mt-8 mb-3">
    <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style="width: 100%">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">
                    {{ __("pages/home.welcome") }}
                </h1>
                <p class="text-lead text-white">
                    {{ __("pages/home.project_description") }}
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
            <div class="card d-inline-flex mt-5">
                <div class="card-body">
                    <a href="javascript:" class="card-title h5 d-block text-darker">
                        {{ __("pages/home.thoth") }}
                    </a>
                    <p class="card-description mb-0">
                        {{ __("pages/home.thoth_description") }}
                    </p>
                </div>
            </div>

            <div class="grid-items-2 gap-3 card-group mt-4 pb-3">
                @foreach ([
                "questions" => "ni ni-bullet-list-67",
                "relevant_data" => "ni ni-single-copy-04",
                "quality" => "ni ni-like-2",
                "analyse_data" => "ni ni-chart-bar-32"
                ]
                as $key => $icon)
                <div class="card rounded-3 p-3 d-flex flex-column h-100">
                    <div class="card-body pt-2 d-flex flex-column">
                        <a href="javascript:" class="card-title h5 d-flex align-items-center gap-2 text-darker">
                            <i class="{{ $icon }}"></i>
                            {{ __("pages/home." . $key) }}
                        </a>
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

    <div class="row mt-3">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-project-diagram fa-2x mb-2"></i>
                        <h2 class="h2 card-title mt-auto"><span id="project-count">0</span></h2>
                        <h6 class="h6 card-text">{{ __("pages/home.total_projects") }} </h6>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h2 class="card-title mt-auto hover-text"><span id="user-count">0</span></h2>
                        <h6 class="card-text">{{ __("pages/home.total_users") }}</h6>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h2 class="card-title mt-auto"><span id="total-finished-projects-count">0</span></h2>
                        <h6 class="card-text">{{ __("pages/home.completed_projects") }}</h6>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-spinner fa-2x mb-2"></i>
                        <h2 class="card-title mt-auto"><span id="total-ongoing-projects-count">0</span></h2>
                        <h6 class="card-text">{{ __("pages/home.ongoing_projects") }}</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Rodapé com links para Termos e Política de Privacidade e para o topo da página -->
        <div class="col-12">
            <div class="card text-center h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <!-- Nome do site e copyright à esquerda -->
                    <p class="mb-0 text-muted">
                        © {{ date('Y') }} - Thoth :: Tool for SLR
                    </p>

                    <!-- Termos e Política de Privacidade e Voltar ao Topo à direita -->
                    <div class="d-flex gap-3">
                        <!-- Link para Termos e Política de Privacidade -->
                        <a href="{{ url('/terms') }}" class="text-muted">
                            <i class="fas fa-user-shield me-1"></i>
                            {{ __("pages/home.terms_and_conditions") }}
                        </a>

                        <!-- Link para Voltar ao Topo com ícone -->
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

@endsection

@push("js")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
        const totalUsers = {{ $total_users }};
        const totalProjects = {{ $total_projects }};
        const totalFinishedProjects = {{ $total_finished_projects }};
        const totalOngoingProjects = {{ $total_ongoing_projects }};

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

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

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

        animateIfVisible('user-count', totalUsers);
        animateIfVisible('project-count', totalProjects);
        animateIfVisible('total-finished-projects-count', totalFinishedProjects);
        animateIfVisible('total-ongoing-projects-count', totalOngoingProjects);
    });
    </script>
@endpush

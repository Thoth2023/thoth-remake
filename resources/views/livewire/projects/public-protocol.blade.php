<div>
    <!-- Botão -->
    <button wire:click="showPublicProtocol"
            class="btn py-1 px-3 btn-outline-info">
        <i class="fas fa-file-alt"></i>
        {{ __('project/public_protocol.protocol') }}
    </button>

    @if($showModal)
        <div class="modal fade show" style="display:block;" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('project/public_protocol.public_protocol') }}</h5>
                        <button wire:click="downloadPdf" class="btn btn-primary btn-sm">
                            {{ __('project/public_protocol.download_pdf') }}
                        </button>
                    </div>

                    <div class="modal-body">

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <button class="nav-link active"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-protocol">
                                    {{ __('project/public_protocol.protocol') }}
                                </button>
                            </li>
                            <!-- Tabs
                            <li class="nav-item">
                                <button class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-reports">
                                __('project/public_protocol.protocol')
                                </button>
                            </li>-->
                        </ul>

                        <div class="tab-content">

                            <!-- Aba Protocolo -->
                            <div class="tab-pane fade show active" id="tab-protocol">
                                <div class="row">

                                    <div class="col-md-12 mb-1">
                                        @livewire('projects.public.project-info', ['project' => $project])
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        @livewire('projects.public.project-overview', ['project' => $project])
                                    </div>

                                    <!-- Search Strategy -->
                                    <div class="col-md-12 mb-4">
                                        <h6 class="text-uppercase mb-2">{{ __('project/public_protocol.search_strategy') }}</h6>

                                        @if(!empty($searchStrategy?->description))
                                            <div class="protocol-box mb-4">
                                                <div class="protocol-text mt-2">
                                                    {{ nl2br(strip_tags($searchStrategy->description)) }}
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-muted small">{{ __('project/public_protocol.no_search_strategy') }}</p>
                                        @endif
                                    </div>

                                    <!-- Questions -->
                                    <div class="col-md-12 mb-4 mt-4">
                                        <h6 class="text-uppercase">{{ __('project/public_protocol.research_questions') }}</h6>
                                        @livewire('projects.public.research-questions', ['project' => $project], key('rq-'.$project->id_project))
                                    </div>

                                    <!-- Criteria -->
                                    <div class="col-md-12 mb-2">
                                        <h6 class="text-uppercase">{{ __('project/public_protocol.criteria') }}</h6>
                                        @livewire('projects.public.criterias', ['project' => $project])
                                    </div>

                                    <!-- Search Terms -->
                                    <div class="col-md-12 mb-4">
                                        @livewire('projects.public.project-terms', ['project' => $project])
                                    </div>

                                    <!-- Quality-->
                                    <div class="col-md-12 mb-4 mt-4">
                                        <h6 class="text-uppercase">{{ __('project/public_protocol.quality_assessment') }}</h6>
                                        @livewire('projects.public.project-quality-public', ['project' => $project])
                                    </div>

                                    <!-- Quality-->
                                    <div class="col-md-12 mb-2">
                                        <h6 class="text-uppercase">{{ __('project/public_protocol.data_extraction') }}</h6>
                                        @livewire('projects.public.project-data-extraction-public', ['project' => $project])
                                    </div>
                                </div>
                            </div>

                            <!-- Aba Relatórios -->
                            <div class="tab-pane fade" id="tab-reports">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-uppercase mb-2">
                                            {{ __('project/public_protocol.overview') }}
                                        </h6>
                                    <!--Chamar aqui o componente livewire dos gráficos -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="closeModal">
                            {{ __('project/conducting.study-selection.modal.close') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show"></div>
    @endif
</div>

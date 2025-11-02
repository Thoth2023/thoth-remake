<div>
    <!-- Botão do Protocolo Público - Só aparece se o projeto for do próprio usuário ou público -->
        <button wire:click="showPublicProtocol" class="btn py-1 px-3 btn-outline-info" data-toggle="tooltip" data-original-title="Public Protocol">
            <i class="fas fa-file-alt"></i>
            {{ __('project/public_protocol.protocol') }}
        </button>

    <!-- Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('project/public_protocol.public_protocol') }}</h5>
                        <div class="d-flex gap-2">
                            <button wire:click="downloadPdf" class="btn btn-primary btn-sm">
                                {{ __('project/public_protocol.download_pdf') }}
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link @if($activeTab === 'protocol') active @endif"
                                        wire:click="setActiveTab('protocol')">
                                    {{ __('project/public_protocol.protocol') }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link @if($activeTab === 'reports') active @endif"
                                        wire:click="setActiveTab('reports')">
                                    {{ __('project/public_protocol.reports') }}
                                </button>
                            </li>
                        </ul>

                        <!-- Conteúdo das Tabs -->
                        <div class="tab-content">
                            <!-- Tab do Protocolo -->
                            <div class="tab-pane fade @if($activeTab === 'protocol') show active @endif">
                                <div class="row">
                                    <!-- Project Info -->
                                    <div class="col-md-12 mb-1">
                                        @livewire('projects.public.project-info', ['project' => $project])
                                    </div>
                                    <!-- Project Overview-->
                                    <div class="col-md-12 mb-4">
                                        @livewire('projects.public.project-overview', ['project' => $project])
                                    </div>
                                    {{-- Search Strategy --}}
                                    <div class="col-md-12 mb-6">
                                        <h6 class="text-uppercase mb-2">
                                            {{ __('project/public_protocol.search_strategy') }}
                                        </h6>

                                        @if(!empty($searchStrategy?->description))
                                            <div class="protocol-box mb-2">
                                                <div class="text-break">
                                                    {!! nl2br($searchStrategy->description) !!}
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-muted small">{{ __('project/public_protocol.no_search_strategy') }}</p>
                                        @endif
                                    </div>
                                    <!-- Research Questions -->
                                    <div class="col-md-12 mb-4">
                                        <h6 class="text-uppercase">{{ __('project/public_protocol.research_questions') }}</h6>
                                        @livewire('projects.public.research-questions', ['project' => $project], key('questions-'.$project->id_project))
                                    </div>
                                    <!-- Criterias -->
                                    <div class="col-md-12 mb-4">
                                        <h6 class="text-uppercase">{{ __('project/public_protocol.criteria') }}</h6>
                                        @livewire('projects.public.criterias', ['project' => $project])
                                    </div>
                                    <!-- Search String -->
                                    <div class="col-md-12 mb-4">
                                        @livewire('projects.public.project-terms', ['project' => $project])
                                    </div>
                                </div>
                            </div>

                            <!-- Tab dos Relatórios -->
                            <div class="tab-pane fade @if($activeTab === 'reports') show active @endif">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-muted">{{ __('project/public_protocol.reports_coming_soon') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            {{ __('project/conducting.study-selection.modal.close' )}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Backdrop -->
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

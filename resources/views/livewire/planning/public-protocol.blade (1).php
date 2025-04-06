<div>
    <!-- Botão do Protocolo Público - Só aparece se o projeto for público -->
    @if($project->is_public)
        <button wire:click="showPublicProtocol" class="btn btn-info btn-sm ms-2">
            <i class="fas fa-eye"></i> {{ __('project.public_protocol') }}
        </button>
    @endif

    <!-- Modal -->
    @if($showModal)
    <div class="modal fade show" style="display: block" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $project->title }} - {{ __('project.protocol_and_reports') }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link @if($activeTab === 'protocol') active @endif" 
                                    wire:click="setActiveTab('protocol')">
                                {{ __('project.protocol') }}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link @if($activeTab === 'reports') active @endif" 
                                    wire:click="setActiveTab('reports')">
                                {{ __('project.reports') }}
                            </button>
                        </li>
                    </ul>

                    <!-- Conteúdo das Tabs -->
                    <div class="tab-content">
                        <!-- Tab do Protocolo -->
                        <div class="tab-pane fade @if($activeTab === 'protocol') show active @endif">
                            <div class="row">
                                <!-- Research Questions -->
                                <div class="col-md-12 mb-4">
                                    <h6 class="text-uppercase">{{ __('project.research_questions') }}</h6>
                                    @livewire('planning.questions.show', ['project' => $project], key('questions-'.$project->id_project))
                                </div>
                            </div>
                        </div>

                        <!-- Tab dos Relatórios -->
                        <div class="tab-pane fade @if($activeTab === 'reports') show active @endif">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-muted">{{ __('project.reports_coming_soon') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Backdrop -->
    <div class="modal-backdrop fade show"></div>
    @endif
</div>

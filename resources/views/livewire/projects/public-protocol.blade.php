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
                                    <!-- Research Questions -->
                                    <div class="col-md-12 mb-4">
                                        <h6 class="text-uppercase">{{ __('project/public_protocol.research_questions') }}</h6>
                                        @livewire('projects.public.research-questions', ['project' => $project], key('questions-'.$project->id_project))
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

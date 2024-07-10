<div>
    <div class="card d-inline-flex mt-5 mb-3 w-100">
        <div class="card-body">
            <a href="javascript:" class="card-title h5 d-block text-darker">
                {{ __("page-management/management.faq-management.table.title") }}
            </a>
        </div>
        <div class="overflow-auto px-4 py-1" style="max-height: 428px; ">
            <button wire:click="openCreateModal" class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#faqModal">Add Nova Pergunta</button>
            <button wire:click="openHistoryModal" class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#historyModal">Histórico</button>
            <button wire:click="openPreviewModal" class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#previewModal">Preview</button>
            <table class="table table-hover">
                <thead class="table-light sticky-top custom-gray-text" style="color: #58545b">
                    <tr>
                        <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem; width: 40%;">
                            {{ __("page-management/management.faq-management.table.headers.request") }}
                        </th>
                        <th style="padding: 0.5rem 0.75rem; width: 40%;">
                            {{ __("page-management/management.faq-management.table.headers.response") }}
                        </th>
                        <th class="text-center" style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem; width: 40%;">
                            {{ __("page-management/management.faq-management.table.headers.actions") }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($faq as $f)
                    <tr wire:key="{{ $f->id }}">
                        <td class="px-3 max-text-wrap" style="max-width: 40%; white-space: normal;">
                            <div id="question-{{ $f->id }}">
                                @if (strlen($f->question) <= 30)
                                    {{ $f->question }}
                                @else
                                    @if ($showFullText[$f->id] ?? false)
                                        {{ $f->question }}
                                    @else
                                        {{ Str::limit($f->question, 100) }}
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td class="px-3 max-text-wrap" style="white-space: normal;">
                            <div id="response-{{ $f->id }}">
                                @if ($showFullText[$f->id] ?? false)
                                    {{ $f->response }}
                                @else
                                    {{ Str::limit($f->response, 500) }}
                                @endif
                            </div>
                        </td>
                        <td class="px-3" style="vertical-align: middle;">
                            <div class="d-flex gap-2">
                                <button wire:click="openCreateModal({{ $f->id }})" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqModal">
                                    <i class="fa fa-pencil"></i> {{ __("page-management/management.faq-management.table.actions.edit") }}
                                </button>
                                <x-helpers.confirm-modal
                                    modalTitle="{{ __('page-management/management.faq-management.modal.delete.title') }}"
                                    modalContent="{{ __('page-management/management.faq-management.modal.delete.description') }}"
                                    textClose="{{ __('page-management/management.faq-management.modal.delete.cancel') }}"
                                    textConfirm="{{ __('page-management/management.faq-management.modal.delete.approve') }}"
                                    class="btn btn-danger btn-sm"
                                    onConfirm="delete({{ $f->id }})"
                                    wire:key="delete-{{ $f->id }}"
                                >
                                    <i class="fa fa-trash"></i> {{ __("page-management/management.faq-management.table.actions.delete") }}
                                </x-helpers.confirm-modal>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <x-helpers.description>
                                {{ __("page-management/management.faq-management.table.empty") }}
                            </x-helpers.description>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal de Criação de Pergunta e Resposta -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="faqModalLabel">{{ __("page-management/management.faq-management.modal.create.title") }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label for="question" class="form-label">{{ __("page-management/management.faq-management.table.headers.request") }}</label>
                            <input type="text" class="form-control" id="question" wire:model="question">
                            @error('question') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="response" class="form-label">{{ __("page-management/management.faq-management.table.headers.response") }}</label>
                            <textarea class="form-control" id="response" wire:model="response"></textarea>
                            @error('response') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Salvar</button>
                        <button type="button" wire:click="closeCreateModal" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Histórico -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" style="overflow-x: hidden;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalLabel">Histórico de Perguntas e Respostas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeHistoryModal"></button>
                </div>
                <div class="modal-body" style="overflow-x: auto;">
                    <table class="table table-hover" style="min-width: 600px;">
                        <thead>
                            <tr>
                                <th>Pergunta</th>
                                <th>Resposta</th>
                                <th>Data/Hora</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faqHistories as $history)
                            <tr>
                                <td class="px-3 max-text-wrap" style="max-width: 40%; white-space: normal;">
                                    <div>{{ $history->question }}</div>
                                </td>
                                <td class="px-3 max-text-wrap" style="max-width: 40%; white-space: normal;">
                                    <div>{{ $history->response }}</div>
                                </td>
                                <td>{{ $history->created_at }}</td>
                                <td>
                                    <button wire:click="restoreVersion({{ $history->id }})" class="btn btn-primary btn-sm">Restaurar</button>
                                    <button wire:click="deleteVersion({{ $history->id }})" class="btn btn-danger btn-sm">Deletar</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Nenhum histórico encontrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Pré-visualização -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Pré-visualização da Página Help</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('layouts.navbars.guest.navbar', ['title' => 'Help'])
                    <div class="container mt-8 mb-3">
                        <div class="page-header d-flex flex-column pt-4 pb-9 border-radius-lg">
                            <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style="width: 100%">
                                <div class="col-lg-6 text-center mx-auto">
                                    <h1 class="text-white">FAQ</h1>
                                    <p class="text-lead text-white">
                                        {{ __('pages/help.10_questions') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                                <div class="card d-inline-flex p-3 mt-8 mb-5">
                                    <div class="card-body pt-2">
                                        <a href="javascript:;" class="card-title h4 d-block text-darker">
                                            Thoth 2.0
                                        </a>
                                        <div class="card-body pt-2">
                                            <a href="javascript:" class="card-title h4 d-block text-darker">
                                                {{ __('pages/help.common_questions') }}
                                            </a>
                                        </div>
                                        <div class="accordion" id="accordionExample">
                                            @foreach ($faq as $item)
                                                <div class="accordion-item{{ $item->id }}">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $item->id }}" aria-expanded="true" aria-controls="collapse{{ $item->id }}">
                                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                                                {{ $item->question }}
                                                            </a>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $item->id }}" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            {{ $item->response }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


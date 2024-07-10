<div class="card d-inline-flex mt-5 mb-3 w-100">
    <div class="card-body">
        <a href="javascript:" class="card-title h5 d-block text-darker">
            {{ __("page-management/home-manager.home.table.title") }}
        </a>
    </div>
    <div class="overflow-auto px-4 py-1" style="max-height: 428px">
    <button wire:click="openCreateModal" class="btn btn-primary"  type="button"  data-bs-toggle="modal" data-bs-target="#ModalHome">Add Nova Descrição</button>
        <table class="table table-responsive table-hover">
            <thead
                class="table-light sticky-top custom-gray-text"
                style="color: #58545b"
            >
                <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem; width: 20%;">
                    {{ __("page-management/home-manager.home.table.headers.request") }}
                </th>
                <th style="padding: 0.5rem 0.75rem; width: 40%;">
                    {{ __("page-management/home-manager.home.table.headers.response") }}
                </th>
                <th style="padding: 0.5rem 0.75rem; width: 20%;">
                    {{ __("page-management/home-manager.home.table.headers.icon") }}
                </th>
                <th
                    class="text-center"
                    style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem; width: 20%;"
                >
                    {{ __("page-management/home-manager.home.table.headers.actions") }}
                </th>
            </thead>
            <tbody class="overflow-x-auto">
                @forelse ($homeObjs as $home)
                    <tr wire:key="{{ $home->id }}">
                        <td class="px-2" data-search>
                            {{ $home->title }}
                        </td>
                        <td class="px-3 max-text-wrap" style="width: 5px">
                            {{ $home->description }}
                        </td>
                        <td class="px-2" >
                            {{ $home->icon }}
                        </td>
                        <td class="px-2">
                            <div class="d-flex gap-2">
                                <button wire:click="openEditModal({{$home->id}})" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalHome">
                                    <i class="fa fa-minus"></i> {{ __("page-management/home-manager.home.table.actions.edit") }}
                                </button>
                                <x-helpers.confirm-modal
                                    modalTitle="{{ __('page-management/home-manager.home.modal.delete.title') }}"
                                    modalContent="{{ __('page-management/home-manager.home.modal.delete.description') }}"
                                    textClose="{{ __('page-management/home-manager.home.modal.delete.cancel') }}"
                                    textConfirm="{{ __('page-management/home-manager.home.modal.delete.approve') }}"
                                    class="btn py-1 px-3 btn-danger"
                                    onConfirm="delete({{ $home->id }})"
                                    wire:key="Deletar{{ $home->id }}"
                                >
                                    <i class="fa fa-minus"></i>
                                    {{ __("page-management/home-manager.home.table.actions.delete") }}
                                </x-helpers.confirm-modal>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <x-helpers.description>
                                {{ __("page-management/home-manager.home.table.empty") }}
                            </x-helpers.description>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <div class="modal fade" id="ModalHome" tabindex="-1" aria-labelledby="ModalHomeLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalHomeLabel">
                        @if($isEditMode)
                            {{ __("page-management/home-manager.home.modal.edit.title") }}
                        @else
                            {{ __("page-management/home-manager.home.modal.create.title") }}
                        @endif</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="store">
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __("page-management/home-manager.home.table.headers.request") }}</label>
                                <input type="text" class="form-control" id="title" wire:model="title">
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __("page-management/home-manager.home.table.headers.response") }}</label>
                                <textarea class="form-control" id="description" wire:model="description"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="icon" class="form-label">{{ __("page-management/home-manager.home.table.headers.icon") }}</label>
                                <input type="text" class="form-control" id="icon" wire:model="icon">
                                @error('icon') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                Salvar
                            </button>
                            <button type="button" wire:click="closeCreateModal" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


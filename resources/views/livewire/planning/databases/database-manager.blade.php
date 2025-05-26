<div class="card d-inline-flex mt-5 mb-3 w-100">
    <div class="card-body">
        <a href="#" onclick="event.preventDefault();" class="card-title h5 d-block text-darker" style="cursor: default; transition: color 0.2s;">
            {{ __("project/planning.databases.database-manager.table.title") }}
        </a>
    </div>
    <div class="overflow-auto px-4 py-1" style="max-height: 428px">
        <table class="table table-responsive table-hover">
            <thead
                class="table-light sticky-top custom-gray-text"
                style="color: #58545b"
            >
                <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem">
                    {{ __("project/planning.databases.database-manager.table.headers.name") }}
                </th>
                <th class="text-wrap" style="padding: 0.5rem 0.75rem">
                    {{ __("project/planning.databases.database-manager.table.headers.link") }}
                </th>
                <th style="padding: 0.5rem 0.75rem">
                    {{ __("project/planning.databases.database-manager.table.headers.status") }}
                </th>
                <th
                    class="text-center"
                    style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem"
                >
                    {{ __("project/planning.databases.database-manager.table.headers.actions") }}
                </th>
            </thead>
            <tbody class="overflow-x-auto">
                @forelse ($databases as $database)
                    <tr wire:key="{{ $database->id_database }}">
                        <td class="px-3" data-search>
                            {{ $database->name }}
                        </td>
                        <td class="px-2 max- text-wrap" style="width: 5px">
                            <a href="{{ $database->link }}" target="_blank">
                                {{ $database->link }}
                            </a>
                        </td>
                        <td class="px-2">
                            {{ __("project/planning.databases.database-manager.table.states." . $database->state) }}
                        </td>
                        <td class="px-3">
                            <div class="d-flex gap-2">
                                <x-helpers.confirm-modal
                                    modalTitle="{{ __('project/planning.databases.database-manager.modal.reject.title') }}"
                                    modalContent="{{ __('project/planning.databases.database-manager.modal.reject.description') }}"
                                    textClose="{{ __('project/planning.databases.database-manager.modal.reject.cancel') }}"
                                    textConfirm="{{ __('project/planning.databases.database-manager.modal.reject.reject') }}"
                                    class="btn py-1 px-3 btn-danger"
                                    onConfirm="rejectDatabase({{ $database->id_database }})"
                                    wire:key="reject-{{ $database->id_database }}"
                                >
                                    <i class="fa fa-minus"></i>
                                    {{ __("project/planning.databases.database-manager.table.actions.reject") }}
                                </x-helpers.confirm-modal>

                                <x-helpers.confirm-modal
                                    modalTitle="{{ __('project/planning.databases.database-manager.modal.approve.title') }}"
                                    modalContent="{{ __('project/planning.databases.database-manager.modal.approve.description') }}"
                                    textClose="{{ __('project/planning.databases.database-manager.modal.approve.cancel') }}"
                                    textConfirm="{{ __('project/planning.databases.database-manager.modal.approve.approve') }}"
                                    class="btn py-1 px-3 btn-success"
                                    onConfirm="approveDatabase({{ $database->id_database }})"
                                    wire:key="approve-{{ $database->id_database }}"
                                >
                                    <i class="fa fa-plus"></i>
                                    {{ __("project/planning.databases.database-manager.table.actions.approve") }}
                                </x-helpers.confirm-modal>

                                <x-helpers.confirm-modal
                                    modalTitle="{{ __('project/planning.databases.database-manager.modal.delete.title') }}"
                                    modalContent="{{ __('project/planning.databases.database-manager.modal.delete.description') }}"
                                    textClose="{{ __('project/planning.databases.database-manager.modal.delete.cancel') }}"
                                    textConfirm="{{ __('project/planning.databases.database-manager.modal.delete.delete') }}"
                                    class="btn py-1 px-3 btn-outline-danger"
                                    onConfirm="deleteSuggestion({{ $database->id_database }})"
                                >
                                    <i class="fas fa-trash"></i>
                                </x-helpers.confirm-modal>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <x-helpers.description>
                                {{ __("project/planning.databases.database-manager.table.empty") }}
                            </x-helpers.description>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card d-inline-flex mt-5 mb-3 w-100">
    <div class="card-body">
        <a href="javascript:" class="card-title h5 d-block text-darker">
            {{ __("page-management/management.faq-management.title") }}
        </a>
    </div>
    <div class="overflow-auto px-4 py-1" style="max-height: 428px">
        <table class="table table-responsive table-hover">
            <thead
                class="table-light sticky-top custom-gray-text"
                style="color: #58545b"
            >
                <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem">
                    {{ __("page-management/management.faq-management.table.headers.request") }}
                </th>
                <th style="padding: 0.5rem 0.75rem">
                    {{ __("page-management/management.faq-management.table.headers.response") }}
                </th>
                <th
                    class="text-center"
                    style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem"
                >
                    {{ __("page-management/management.faq-management.table.headers.actions") }}
                </th>
            </thead>
            <tbody class="overflow-x-auto">
                @forelse ($faq as $f)
                    <tr wire:key="{{ $f->id }}">
                        <td class="px-3" data-search>
                            {{ $f->question }}
                        </td>
                        <td class="px-3 max-text-wrap" style="width: 5px">
                            {{ $f->response }}
                        </td>
                        <td class="px-2">
                            <div class="d-flex gap-2">
                                <button wire:click="editFaq({{ $f->id }})" class="btn btn-primary btn-sm">
                                    Editar
                                </button>
                                <button wire:click="deleteFaq({{ $f->id }})" class="btn btn-danger btn-sm">
                                    Deletar
                                </button>
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

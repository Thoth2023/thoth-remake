@extends("layouts.app")

@section("content")
    @include("layouts.navbars.guest.navbar", ["title" => __("pages.home.home")])
    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4"
                style="background-color: rgba(85, 101, 128, 1); width: 100%"
            >
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white">
                        {{ __("project/planning.databases.database-manager.title") }}
                    </h1>
                    <p class="text-lead text-white">
                        {{ __("project/planning.databases.database-manager.description") }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                <div class="card d-inline-flex mt-5">
                    <div class="card-body">
                        <a
                            href="javascript:"
                            class="card-title h5 d-block text-darker"
                        >
                            {{ __("project/planning.databases.database-manager.table.title") }}
                        </a>
                    </div>
                    <div
                        class="overflow-auto px-4 py-1"
                        style="max-height: 428px"
                    >
                        <table class="table table-responsive table-hover">
                            <thead
                                class="table-light sticky-top custom-gray-text"
                                style="color: #58545b"
                            >
                                <th
                                    style="
                                        border-radius: 0.75rem 0 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                >
                                    {{ __("project/planning.databases.database-manager.table.headers.name") }}
                                </th>
                                <th
                                    class="text-wrap"
                                    style="padding: 0.5rem 0.75rem"
                                >
                                    {{ __("project/planning.databases.database-manager.table.headers.link") }}
                                </th>
                                <th style="padding: 0.5rem 0.75rem">
                                    {{ __("project/planning.databases.database-manager.table.headers.status") }}
                                </th>
                                <th
                                    class="text-center"
                                    style="
                                        border-radius: 0 0.75rem 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                >
                                    {{ __("project/planning.databases.database-manager.table.headers.actions") }}
                                </th>
                            </thead>
                            <tbody class="overflow-x-auto">
                                @forelse ($databases as $database)
                                    <tr>
                                        <td class="px-3" data-search>
                                            {{ $database->name }}
                                        </td>
                                        <td
                                            class="px-2 max- text-wrap"
                                            style="width: 5px"
                                        >
                                            <a
                                                href="{{ $database->link }}"
                                                target="_blank"
                                            >
                                                {{ $database->link }}
                                            </a>
                                        </td>
                                        <td class="px-2">
                                            {{ $database->state }}
                                        </td>
                                        <td class="px-3">
                                            <div class="d-flex gap-1">
                                                <x-helpers.confirm-modal
                                                    modalTitle="kk"
                                                    modalContent="Tem certeza que deseja recusar essa sugestão? A sugestão será removida."
                                                    class="btn py-1 px-3 btn-danger"
                                                    onConfirm="rejectDatabase({{ $database->id_database }})"
                                                >
                                                    <i class="fa fa-minus"></i>
                                                    {{ __("project/planning.databases.database-manager.table.actions.reject") }}
                                                </x-helpers.confirm-modal>
                                                <x-helpers.confirm-modal
                                                    modalTitle="Aceitar sugestão"
                                                    modalContent="Tem certeza que deseja aceitar essa sugestão? A sugestão será adicionada a lista de bases de dados."
                                                    class="btn py-1 px-3 btn-success"
                                                    onConfirm="approveDatabase({{ $database->id_database }})"
                                                >
                                                    <i class="fa fa-plus"></i>
                                                    {{ __("project/planning.databases.database-manager.table.actions.approve") }}
                                                </x-helpers.confirm-modal>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            colspan="3"
                                            class="text-center py-4"
                                        >
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
            </div>
        </div>
    </div>
@endsection

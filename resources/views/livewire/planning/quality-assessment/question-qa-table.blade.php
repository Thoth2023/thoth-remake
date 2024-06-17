<div class="card" style="border-radius: 20px 20px 0px 0px">
    <div class="mt-0 mx-0">
        <div class="table-container">
            <table class="table table-custom-hover m-0">
                <thead class="table-light">
                    <tr class="p-0 m-0">
                        <th class="p-1 rounded-l-sm" style="width: 20px"></th>
                        <th scope="col" class="p-1">
                            {{ __("project/planning.data-extraction.table.header.id") }}
                        </th>
                        <th scope="col" class="p-1">
                            {{ __("project/planning.data-extraction.table.header.description") }}
                        </th>
                        <th scope="col" class="p-1">Peso</th>
                        <th scope="col" class="p-1 rounded-r-sm">
                            {{ __("project/planning.data-extraction.table.header.actions") }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <td>
                                {{-- @if ($questions->options->isNotEmpty()) --}}
                                <x-table.accordion-button />
                                {{-- @endif --}}
                            </td>
                            <td>{{ $question->id_qa }}</td>
                            <td class="text-wrap">
                                {{ $question->description }}
                            </td>
                            <td>
                                {{ $question->weight }}
                            </td>
                            <td>
                                <div style="min-width: fit-content">
                                    <button
                                        type="button"
                                        {{-- wire:click="sendEditDataToAnotherComponent({{ $question }})" --}}
                                        class="btn btn-outline-secondary py-1 px-3 m-0"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        class="btn btn-outline-danger py-1 px-3 m-0"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <x-table.accordion-content>
                            <td colspan="5">
                                <div class="d-grid gap-3">
                                    {{-- @foreach ($questions as $question) --}}
                                    <div class="table-accordion-item">
                                        <span class="d-flex text-break">
                                            Teste
                                        </span>
                                        <div>
                                            <button
                                                class="btn btn-outline-secondary py-0 px-3 m-0"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                class="btn btn-outline-danger py-0 px-3 m-0"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-accordion-item">
                                        <span class="d-flex text-break">
                                            Teste 2
                                        </span>
                                        <div>
                                            <button
                                                class="btn btn-outline-secondary py-0 px-3 m-0"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                class="btn btn-outline-danger py-0 px-3 m-0"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-accordion-item">
                                        <span class="d-flex text-break">
                                            Teste 3
                                        </span>
                                        <div>
                                            <button
                                                class="btn btn-outline-secondary py-0 px-3 m-0"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                class="btn btn-outline-danger py-0 px-3 m-0"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- @endforeach --}}
                                </div>
                            </td>
                        </x-table.accordion-content>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

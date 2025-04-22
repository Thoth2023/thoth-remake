<div class="card mt-4" style="border-radius: 20px 20px 0px 0px">
    {{-- <div class="card-body"> --}}
    <div class="mt-0 mx-0">
        <div class="table-container">
            <table class="table table-custom-hover m-0">
                <thead class="table-light">
                    <tr class="p-0 m-0">
                        <th class="p-1 rounded-l-sm" style="width: 20px"></th>
                        <th scope="col" class="p-1">
                            {{ translationPlanning("data-extraction.table.header.id") }}
                        </th>
                        <th scope="col" class="p-1">
                            {{ translationPlanning("data-extraction.table.header.description") }}
                        </th>
                        <th scope="col" class="p-1">
                            {{ translationPlanning("data-extraction.table.header.question-type") }}
                        </th>
                        <th scope="col" class="p-1 rounded-r-sm">
                            {{ translationPlanning("data-extraction.table.header.actions") }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->dataExtractionQuestions as $question)
                        <tr>
                            <td>
                                @if ($question->options->isNotEmpty() && $question->type > 1)
                                    <x-table.accordion-button />
                                @endif
                            </td>
                            <td>{{ $question->id }}</td>
                            <td class="text-wrap">
                                {{ $question->description }}
                            </td>
                            <td>
                                {{ $question->question_type->type }}
                            </td>
                            <td>
                                <div style="min-width: fit-content">
                                    <button
                                        type="button"
                                        wire:click="editQuestion({{ $question }})"
                                        class="btn btn-outline-secondary py-1 px-3 m-0"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="deleteQuestion({{ $question }})"
                                        class="btn btn-outline-danger py-1 px-3 m-0"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @if ($question->options->isNotEmpty() && $question->type > 1)
                            <x-table.accordion-content>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="1" > <!-- Adicionando a classe text-end -->

                                    <div class="d-grid">
                                        @foreach ($question->options as $option)
                                            <div class="table-accordion-item d-flex justify-content-between ">
                                                <span class="text-break">
                                                    {{ $option->description }}
                                                </span>
                                                <div>
                                                    <button
                                                        type="button"
                                                        wire:click="editOption({{ $option }})"
                                                        class="btn btn-outline-secondary py-0 px-3 m-0"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        wire:click="deleteOption({{ $option }})"
                                                        class="btn btn-outline-danger py-0 px-3 m-0"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td></td>
                            </x-table.accordion-content>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

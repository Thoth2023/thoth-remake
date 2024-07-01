<div class="card mt-4">
    {{-- <div class="card-body"> --}}
    <div class="mt-0 mx-0" style="border-radius: 20px">
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
                        <th scope="col" class="p-1">
                            {{ __("project/planning.data-extraction.table.header.question-type") }}
                        </th>
                        <th scope="col" class="p-1 rounded-r-sm">
                            {{ __("project/planning.data-extraction.table.header.actions") }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->dataExtractionQuestions as $question)
                        <tr>
                            <td>
                                @if ($question->options->isNotEmpty())
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
                        <x-table.accordion-content>
                            <td colspan="5">
                                <div class="d-grid gap-3">
                                    @foreach ($question->options as $option)
                                        <div class="table-accordion-item">
                                            <span class="d-flex text-break">
                                                {{ $option->description }}
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
                                    @endforeach
                                </div>
                            </td>
                        </x-table.accordion-content>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

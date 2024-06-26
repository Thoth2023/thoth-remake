<div class="card" style="border-radius: 20px 20px 0px 0px">
    <div class="mt-0 mx-0">
        <table class="table table-custom-hover m-0">
            <thead class="table-light">
                <tr class="p-0 m-0">
                    <th class="p-1 pl-3 rounded-l-sm" style="width: 30px"></th>
                    <th scope="col" class="p-1">
                        {{ __("project/planning.data-extraction.table.header.id") }}
                    </th>
                    <th scope="col" class="p-1">
                        {{ __("project/planning.data-extraction.table.header.description") }}
                    </th>
                    <th scope="col" class="p-1">Peso</th>
                    <th scope="col" class="p-1">Mínimo para Aprovar</th>
                    <th scope="col" class="p-1 rounded-r-sm">
                        {{ __("project/planning.data-extraction.table.header.actions") }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>
                            @if ($question->qualityScores->isNotEmpty())
                                <x-table.accordion-button />
                            @endif
                        </td>
                        <td>
                            {{ $question->id }}
                        </td>
                        <td class="text-wrap">
                            {{ $question->description }}
                        </td>
                        <td>
                            {{ $question->weight }}
                        </td>
                        <td>
                            @if ($question->qualityScores->isNotEmpty())
                                <div class="w-100 w-md-50">
                                    <x-select
                                        wire:change="console.log('click')"
                                    >
                                        <option selected disabled value="-1">
                                            Select a Rule
                                        </option>
                                        @foreach ($question->qualityScores as $score)
                                            <option
                                                value="{{ $score->id_score }}"
                                            >
                                                {{ $score->score_rule }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div
                                class="c-flex c-items-center c-justify-center gap-1"
                                style="min-width: fit-content"
                            >
                                <button
                                    type="button"
                                    wire:click="editQuestionQuality({{ $question->id_qa }})"
                                    class="btn btn-outline-secondary py-1 px-3 m-0"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <x-helpers.confirm-modal
                                    modalTitle="Delete Quality Score"
                                    modalContent="This action <strong>cannot</strong> be undone. This will remove the quality score permanently."
                                    class="btn btn-outline-danger py-1 px-3 m-0"
                                    onConfirm="deleteQuestionQuality({{ $question->id_qa }})"
                                >
                                    <i class="fa fa-trash"></i>
                                </x-helpers.confirm-modal>
                            </div>
                        </td>
                    </tr>
                    <x-table.accordion-content>
                        <td colspan="6" wire:key="{{ $question }}">
                            <table class="table table-responsive w-100">
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            class="text-center p-05"
                                        >
                                            Score Rule
                                        </th>
                                        <th
                                            scope="col"
                                            class="text-center p-05"
                                        >
                                            Description
                                        </th>
                                        <th
                                            scope="col"
                                            class="text-center p-05"
                                        >
                                            Score
                                        </th>
                                        <th
                                            scope="col"
                                            class="text-center p-05"
                                        >
                                            {{ __("project/planning.data-extraction.table.header.actions") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($question->qualityScores as $question)
                                        <tr>
                                            <td>
                                                <span
                                                    class="c-flex c-items-center c-justify-center"
                                                >
                                                    {{ $question->score_rule }}
                                                </span>
                                            </td>
                                            <td class="text-wrap">
                                                {{ $question->description }}
                                            </td>
                                            <td>
                                                <span
                                                    class="c-flex c-items-center c-justify-center"
                                                >
                                                    {{ $question->score }}%
                                                </span>
                                            </td>
                                            <td>
                                                <div
                                                    class="c-flex c-items-center c-justify-center gap-1"
                                                >
                                                    <button
                                                        type="button"
                                                        {{-- wire:click="sendEditDataToAnotherComponent({{ $question }})" --}}
                                                        class="btn btn-outline-secondary py-1 px-3 m-0"
                                                    >
                                                        <i
                                                            class="fas fa-edit"
                                                        ></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-outline-danger py-1 px-3 m-0"
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </x-table.accordion-content>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

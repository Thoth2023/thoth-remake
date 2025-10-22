<div class="card" style="border-radius: 20px 20px 0px 0px; min-height: 300px;">
    <div class="mt-0 mx-0" style="max-height: none; overflow-y: auto; min-height: 300px;">
        <table class="table table-custom-hover m-0" style="width: 100%; table-layout: auto; min-height: 300px;">
            <thead class="table-light">
                <tr>
                    <th class="p-1 pl-3" style="width: 5%; text-align: center; vertical-align: middle;"></th>
                    <th scope="col" class="p-1" style="width: 10%; text-align: center; vertical-align: middle;">
                        {{ __("project/planning.data-extraction.table.header.id") }}
                    </th>
                    <th scope="col" class="p-1" style="width: 15%; text-align: center; vertical-align: middle;">
                        {{ __("project/planning.data-extraction.table.header.description") }}
                    </th>
                    <th scope="col" class="p-1" style="width: 10%; text-align: center; vertical-align: middle;">
                        {{ __("project/planning.quality-assessment.question-quality.weight") }}
                    </th>
                    <th scope="col" class="text-center p-1" style="width: 15%; text-align: center; vertical-align: middle;">
                        {{ __("project/planning.quality-assessment.qa-table.min-general-score") }}
                    </th>
                    <th scope="col" class="text-center p-1" style="width: 10%; text-align: center; vertical-align: middle;">
                        {{ __("project/planning.data-extraction.table.header.actions") }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr style="border-top: 1px solid #dee2e6;">
                        <td class="p-2" style="text-align: center; vertical-align: middle;">
                            @if ($question->qualityScores->isNotEmpty())
                                <x-table.accordion-button />
                            @endif
                        </td>
                        <td class="p-2" style="text-align: center; vertical-align: middle;">
                            {{ $question->id }}
                        </td>
                        <td class="text-wrap p-2" style="max-width: 100%; white-space: normal; text-align: center; vertical-align: middle;">
                            {{ $question->description }}
                        </td>
                        <td class="p-2" style="text-align: center; vertical-align: middle;">
                            {{ $question->weight }}
                        </td>
                        <td class="p-2" style="text-align: center; vertical-align: middle;">
                            <div class="d-flex justify-content-center">
                                @if ($question->qualityScores->isNotEmpty())
                                    <div class="w-100">
                                        <x-select
                                            wire:change="updateMinimalScore({{ $question->id_qa }}, $event.target.value)"
                                            style="z-index: 1050; position: relative; width: 100%;"
                                        >
                                            <option
                                                selected
                                                disabled
                                                value="-1"
                                            >
                                                {{ __("project/planning.quality-assessment.question-score.select.rule") }}
                                            </option>
                                            @foreach ($question->qualityScores as $score)
                                                <option
                                                    value="{{ $score->id_score }}"
                                                    <?= $score->id_score == $question->min_to_app ? "selected" : "" ?>
                                                >
                                                    {{ $score->score_rule }}
                                                    ({{ $score->score }}%)
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="p-2" style="text-align: center; vertical-align: middle;">
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
                                    modalContent="Essa ação <strong>não pode</strong> ser desfeita. Isso irá remover a pontuação de qualidade permanentemente."
                                    class="btn btn-outline-danger py-1 px-3 m-0"
                                    onConfirm="deleteQuestionQuality({{ $question->id_qa }})"
                                >
                                    <i class="fas fa-trash"></i>
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
                                            {{ __("project/planning.quality-assessment.question-score.score_rule.title") }}
                                        </th>
                                        <th
                                            scope="col"
                                            class="text-center p-05"
                                        >
                                            {{ __("project/planning.quality-assessment.question-score.description.title") }}
                                        </th>
                                        <th
                                            scope="col"
                                            class="text-center p-05"
                                        >
                                            {{ __("project/planning.quality-assessment.question-score.range.score") }}
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
                                            <td
                                                class="c-flex c-items-center c-justify-center"
                                                style="max-width: 250px"
                                            >
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
                                                        wire:click="editQuestionScore({{ $question->id_score }})"
                                                        class="btn btn-outline-secondary py-1 px-3 m-0"
                                                    >
                                                        <i
                                                            class="fas fa-edit"
                                                        ></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-outline-danger py-1 px-3 m-0"
                                                        wire:click="deleteQuestionScore({{ $question->id_score }})"
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

@script
    <script>
        $wire.on('qa-table', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript

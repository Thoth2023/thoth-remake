<div class="card" style="border-radius: 20px 20px 0px 0px; min-height: 300px;">
    <div class="thoth-card-badge"><b>15</b></div>
    <div class="mt-0 mx-0" style="max-height: none; overflow-y: auto; min-height: 300px;">
        <table class="table table-custom-hover m-0" style="width: 100%; table-layout: auto; min-height: 300px;">
            <thead class="table-light">
            <tr>
                <th class="p-1 pl-3" style="width: 5%; text-align: center; vertical-align: middle;"></th>
                <th scope="col" class="p-1" style="width: 10%; text-align: center; vertical-align: middle;">
                    {{ __('project/planning.data-extraction.table.header.id') }}
                </th>
                <th scope="col" class="p-1" style="width: 15%; text-align: center; vertical-align: middle;">
                    {{ __('project/planning.data-extraction.table.header.description') }}
                </th>
                <th scope="col" class="p-1" style="width: 10%; text-align: center; vertical-align: middle;">
                    {{ __('project/planning.quality-assessment.question-quality.weight') }}
                </th>
                <th scope="col" class="text-center p-1" style="width: 15%; text-align: center; vertical-align: middle;">
                    {{ __('project/planning.quality-assessment.qa-table.min-general-score') }}
                </th>
                <th scope="col" class="text-center p-1" style="width: 10%; text-align: center; vertical-align: middle;">
                    {{ __('project/planning.data-extraction.table.header.actions') }}
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
                                        wire:change="confirmUpdateMinimalScore({{ $question->id_qa }}, $event.target.value)"
                                        style="z-index: 1050; position: relative; width: 100%;"
                                    >
                                        <option selected disabled value="-1">
                                            {{ __('project/planning.quality-assessment.question-score.select.rule') }}
                                        </option>
                                        @foreach ($question->qualityScores as $score)
                                            <option
                                                value="{{ $score->id_score }}"
                                                    <?= $score->id_score == $question->min_to_app ? 'selected' : '' ?>
                                            >
                                                {{ $score->score_rule }} ({{ $score->score }}%)
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="p-2" style="text-align: center; vertical-align: middle;">
                        <div class="c-flex c-items-center c-justify-center gap-1" style="min-width: fit-content">
                            <button type="button"
                                    wire:click="editQuestionQuality({{ $question->id_qa }})"
                                    class="btn btn-outline-secondary py-1 px-3 m-0">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button"
                                    wire:click="confirmDeleteQuestionQuality({{ $question->id_qa }})"
                                    class="btn btn-outline-danger py-1 px-3 m-0">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <x-table.accordion-content>
                    <td colspan="6" wire:key="{{ $question->id_qa }}">
                        <table class="table table-responsive w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center p-05">
                                    {{ __('project/planning.quality-assessment.question-score.score_rule.title') }}
                                </th>
                                <th scope="col" class="text-center p-05">
                                    {{ __('project/planning.quality-assessment.question-score.description.title') }}
                                </th>
                                <th scope="col" class="text-center p-05">
                                    {{ __('project/planning.quality-assessment.question-score.range.score') }}
                                </th>
                                <th scope="col" class="text-center p-05">
                                    {{ __('project/planning.data-extraction.table.header.actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($question->qualityScores as $score)
                                <tr>
                                    <td>
                                                <span class="c-flex c-items-center c-justify-center">
                                                    {{ $score->score_rule }}
                                                </span>
                                    </td>
                                    <td class="c-flex c-items-center c-justify-center" style="max-width: 250px">
                                        {{ $score->description }}
                                    </td>
                                    <td>
                                                <span class="c-flex c-items-center c-justify-center">
                                                    {{ $score->score }}%
                                                </span>
                                    </td>
                                    <td>
                                        <div class="c-flex c-items-center c-justify-center gap-1">
                                            <button type="button"
                                                    wire:click="editQuestionScore({{ $score->id_score }})"
                                                    class="btn btn-outline-secondary py-1 px-3 m-0">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button"
                                                    wire:click="confirmDeleteQuestionScore({{ $score->id_score }})"
                                                    class="btn btn-outline-danger py-1 px-3 m-0">
                                                <i class="fas fa-trash"></i>
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

    {{-- Modal: confirmação de exclusão de questão --}}
    <div wire:ignore>
        <div id="qaDeleteQuestionConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.quality-assessment.question-quality.delete.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($deletionHasEvaluations)
                            <div class="alert alert-warning d-flex align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ __('project/planning.quality-assessment.question-quality.delete.warning_evaluations') }}</span>
                            </div>
                        @endif
                        <p>{{ __('project/planning.quality-assessment.question-quality.delete.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.delete.cancel') }}
                        </button>
                        <button type="button"
                                class="btn {{ $deletionHasEvaluations ? 'btn-danger' : 'btn-outline-danger' }}"
                                wire:click="deleteQuestionQuality('{{ $confirmingDeleteQuestionId }}')"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.delete.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: confirmação de exclusão de score --}}
    <div wire:ignore>
        <div id="qaDeleteScoreConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.quality-assessment.question-quality.delete_score.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($deletionHasEvaluations)
                            <div class="alert alert-warning d-flex align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ __('project/planning.quality-assessment.question-quality.delete_score.warning_evaluations') }}</span>
                            </div>
                        @endif
                        <p>{{ __('project/planning.quality-assessment.question-quality.delete_score.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.delete_score.cancel') }}
                        </button>
                        <button type="button"
                                class="btn {{ $deletionHasEvaluations ? 'btn-danger' : 'btn-outline-danger' }}"
                                wire:click="deleteQuestionScore('{{ $confirmingDeleteScoreId }}')"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.delete_score.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: confirmação de alteração de pontuação mínima --}}
    <div wire:ignore>
        <div id="qaMinScoreConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.quality-assessment.question-quality.min_score.warning_title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>{{ __('project/planning.quality-assessment.question-quality.min_score.warning_evaluations') }}</span>
                        </div>
                        <p>{{ __('project/planning.quality-assessment.question-quality.min_score.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.min_score.cancel') }}
                        </button>
                        <button type="button" class="btn btn-danger"
                                wire:click="confirmMinScore"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.min_score.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('qa-table', ([{ message, type }]) => {
        toasty({ message, type });
    });

    $wire.on('openQaDeleteQuestionConfirm', () => {
        new bootstrap.Modal(document.getElementById('qaDeleteQuestionConfirmModal')).show();
    });

    $wire.on('openQaDeleteScoreConfirm', () => {
        new bootstrap.Modal(document.getElementById('qaDeleteScoreConfirmModal')).show();
    });

    $wire.on('openQaMinScoreConfirm', () => {
        new bootstrap.Modal(document.getElementById('qaMinScoreConfirmModal')).show();
    });
</script>
@endscript

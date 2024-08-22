<div>
    <div class="modal fade" id="paperModalQuality" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    @if ($paper)
                    <h5 class="modal-title" id="paperModalLabel">{{ $paper['title'] }}</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <b>{{ __('project/conducting.quality-assessment.modal.author' )}}: </b>
                            <p>{{ $paper['author'] }}</p>
                        </div>
                        <div class="col-2">
                            <b>{{ __('project/conducting.quality-assessment.modal.year' )}}:</b>
                            <p>{{ $paper['year'] }}</p>
                        </div><div class="col-4">
                            <b>{{ __('project/conducting.quality-assessment.modal.database' )}}:</b>
                            <p>{{ $paper['database_name'] }}</p>
                        </div>
                        <div class="col-2">
                            <a class="btn py-1 px-3 btn-outline-dark" data-toggle="tooltip" data-original-title="Doi" href="https://doi.org/{{ $paper['doi'] }}" target="_blank">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                DOI
                            </a>
                            <a class="btn py-1 px-3 btn-outline-success" data-toggle="tooltip" data-original-title="URL" href="{{ $paper['url'] }}" target="_blank">
                                <i class="fa-solid fa-link"></i>
                                URL
                            </a>
                        </div>

                        <div class="col-12">
                            <b>{{ __('project/conducting.quality-assessment.modal.abstract' )}}: </b>
                            <p>{{ $paper['abstract'] }}</p>
                        </div>
                        <div class="col-12">
                            <b>{{ __('project/conducting.quality-assessment.modal.keywords' )}}: </b>
                            <p>{{ $paper['keywords'] }}</p>
                        </div>
                    </div>
                    <span class="card-header pb-0">
                        <h5 >{{ __('project/conducting.quality-assessment.modal.quality-questions' )}}</h5>
                        <hr class="py-0 m-0 mt-1 mb-3" style="background: #b0b0b0" />
                        @livewire('conducting.quality-assessment.quality-score', ['paper' => $paper['id_paper']],key($paper['id_paper']))
                    </span>

                    <ul class='list-group'>
                        <li class='list-group-item d-flex'>

                            <div class='w-10 pl-2'>
                                <b>
                                    {{ __('project/conducting.quality-assessment.table.id' )}}
                                </b>
                            </div>
                            <div class='w-50 pl-2 pr-2'>
                                <b >
                                    {{ __('project/conducting.quality-assessment.modal.table.description' )}}
                                </b>
                            </div>
                            <div class='w-20 pl-2 ms-auto'>
                                <b >
                                    {!!__('project/conducting.quality-assessment.modal.table.min-to-app' )!!}
                                </b>
                            </div>
                            <div class='w-20 pl-2 ms-auto'>
                                <b >
                                    {{ __('project/conducting.quality-assessment.modal.table.score' )}}
                                </b>
                            </div>

                        </li>
                    </ul>

                    <ul class='list-group list-group-flush'>
                    @foreach ($questions as $question)
                            <x-search.item
                                wire:key="{{ $question->description }}"
                                target="search-papers"
                                class="list-group-item d-flex row w-100"
                            >
                    <div class='w-10 pl-2'>
                        <span data-search>{{ $question->id }}</span>
                    </div>
                    <div class='w-50' >
                        <span data-search>{{ $question->description }}</span>
                    </div>
                    <div class='w-20 ms-auto'>
                             @foreach ($question->qualityScores as $score_min)
                                 @if ($score_min->id_score == $question->min_to_app)
                                <span data-search>   {{ $score_min->score_rule }}</span>
                                 @endif
                              @endforeach
                                @if ($question->min_to_app == NULL)
                                     <span data-search>  N/A </span>
                                @endif
                    </div>
                    <div class='w-20 ms-auto'>
                        <span data-search>
                                <x-select wire:model="selected_questions_score.{{ $question->id_qa }}" wire:change="updateScore({{ $question->id_qa }}, $event.target.value)">
                                     @if(!isset($selected_questions_score[$question->id_qa]))  <!-- Verifica se não há score salvo -->
                                    <option selected disabled>{{ __('project/conducting.quality-assessment.modal.select-score') }}</option>
                                    @endif

                                    @foreach ($question->qualityScores as $score)
                                        <option value="{{ $score->id_score }}"
                                                @if(isset($selected_questions_score[$question->id_qa]) && $selected_questions_score[$question->id_qa] == $score->id_score)
                                                    selected
                                        @endif>
                                        {{ $score->score_rule }}
                                    </option>
                                    @endforeach
                                </x-select>
                        </span>
                    </div>
                            </x-search.item>
                    @endforeach
                    </ul>


                    <hr />
                    <!-- Verificação do status -->
                    @if($paper['status_qa'] != 1 && $paper['status_qa'] != 2)
                        <!-- Apenas mostrar se o status não for Accepted (1) ou Rejected (2) -->
                        <p>{{ __('project/conducting.quality-assessment.modal.option.select' )}}</p>

                        <div class="btn-group mt-2" role="group">
                            <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="Unclassified" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">{{ __('project/conducting.study-selection.modal.option.unclassified' )}}</label>

                            <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="Removed" name="btnradio" id="btnradio1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio1">{{ __('project/conducting.study-selection.modal.option.remove' )}}</label>

                        </div>
                    @endif

                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.quality-assessment.modal.close' )}}</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="successModalQuality" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ session('successMessage') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
@script
<script>
    $(document).ready(function(){
        // mostrar o paper
        $wire.on('show-paper-quality', () => {
            $('#paperModalQuality').modal('show');
        });
        //mostrar msg de sucesso
        Livewire.on('show-success-quality', () => {
            $('#paperModalQuality').modal('hide'); // Hide the paper modal
            $('#successModalQuality').modal('show'); // Show the success modal
        });

        // fechar modal paper
        $('#successModalQuality').on('hidden.bs.modal', function () {
            $('#paperModalQuality').modal('show'); // Reopen the paper modal after success modal is closed
        });
    });
    Livewire.on('reload-paper-modal', () => {
        // Recarregar o componente Livewire para refletir as mudanças
        Livewire.emit('showPaperQuality', @json($paper));
    });

    $wire.on('paper-modal', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript

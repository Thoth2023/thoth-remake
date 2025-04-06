<div>
<div class="modal fade" id="paperModalExtraction" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
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
                        <b>{{ __('project/conducting.data-extraction.modal.author' )}}: </b>
                        <p>{{ $paper['author'] }}</p>
                    </div>
                    <div class="col-2">
                        <b>{{ __('project/conducting.data-extraction.modal.year' )}}:</b>
                        <p>{{ $paper['year'] }}</p>
                    </div><div class="col-4">
                        <b>{{ __('project/conducting.data-extraction.modal.database' )}}:</b>
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
                        <a class="btn py-1 px-3 btn-outline-primary"
                           data-toggle="tooltip"
                           data-original-title="Buscar no Google Scholar"
                           href="https://scholar.google.com/scholar?q={{ urlencode($paper['title']) }}"
                           target="_blank">
                            <i class="fa-solid fa-graduation-cap"></i>
                            Google Scholar
                        </a>
                    </div>
                    @livewire('conducting.data-extraction.paper-status', ['paper' => $paper['id_paper']],key($paper['id_paper']))
                    <div class="col-12">
                        <b>{{ __('project/conducting.data-extraction.modal.abstract' )}}: </b>
                        <p>{{ $paper['abstract'] }}</p>
                    </div>
                    <div class="col-12">
                        <b>{{ __('project/conducting.data-extraction.modal.keywords' )}}: </b>
                        <p>{{ $paper['keywords'] }}</p>
                    </div>
                </div>

                <ul class='list-group list-group-flush'>
                    @foreach ($questions as $question)
                        <x-search.item
                            wire:key="{{ $question->description }}"
                            target="search-papers"
                            class="list-group-item d-flex row w-100"
                            disabled="{{ !$canEdit }}"
                        >
                            <div class='w-10 pl-2'>
                                <span data-search><strong>{{ $question->id }}</strong></span>
                            </div>
                            <div class='w-50'>
                                <span data-search><strong>{{ $question->description }}</strong></span>
                            </div>

                        </x-search.item>

                        @if(optional($question->question_type)->type == 'Text')
                            <div class='w-100 mt-2'>
                                <div wire:ignore.self>
                                    <div x-data="{ timeoutId: null }"
                                        x-ref="editor{{ $question->id_de }}"
                                        x-init="
                                            const quill{{ $question->id_de }} = new Quill($refs.editor{{ $question->id_de }}, {
                                                theme: 'snow'
                                            });
                                            // Set editor to read-only mode if user can't edit
                                            quill{{ $question->id_de }}.enable(@js($canEdit));
                                            
                                            // Preenche o editor com o texto salvo
                                            quill{{ $question->id_de }}.clipboard.dangerouslyPasteHTML(@js($textAnswers[$question->id] ?? ''));
                                            
                                            // Only setup event handlers if user can edit
                                            if (@js($canEdit)) {
                                                // Função de debounce para esperar 3 segundos após parar de digitar
                                                function debounceSave(questionId, content) {
                                                    if (this.timeoutId) {
                                                        clearTimeout(this.timeoutId);
                                                    }
                                                    this.timeoutId = setTimeout(() => {
                                                        $wire.set('textAnswers.' + questionId, content);
                                                        $wire.saveTextAnswer(questionId, content);
                                                    }, 3000);
                                                }
                                                // Evento de blur para salvar o texto quando o editor perde foco
                                                quill{{ $question->id_de }}.root.addEventListener('blur', function () {
                                                    const questionId = @js($question->id_de);
                                                    const content = quill{{ $question->id_de }}.root.innerHTML;
                                                    $wire.set('textAnswers.' + questionId, content);
                                                    $wire.saveTextAnswer(questionId, content);
                                                });
                                                // Evento para aplicar debounce ao alterar o texto
                                                quill{{ $question->id_de }}.on('text-change', function () {
                                                    const questionId = @js($question->id_de);
                                                    const content = quill{{ $question->id_de }}.root.innerHTML;
                                                    debounceSave(questionId, content);
                                                });
                                            }
                                        "
                                        style="height: 100px;">
                                    </div>
                                </div>
                            </div><br/>
                        @elseif(optional($question->question_type)->type == 'Pick One List')
                            <div class='w-100 mt-2'>
                                <x-select wire:model="selectedOptions.{{ $question->id_de }}"
                                          wire:change="saveOptionAnswer({{ $question->id_de }}, $event.target.value)"
                                          disabled="{{ !$canEdit }}">
                                    @if(!isset($selectedOptions[$question->id_de]))  <!-- Verifica se não há opção salva -->
                                    <option selected disabled>{{ __('project/conducting.quality-assessment.modal.select-score') }}</option>
                                    @endif
                                    @foreach ($question->options as $option)

                                        <option value="{{ $option->id_option }}"
                                                @if(isset($selectedOptions[$question->id_de]) && $selectedOptions[$question->id_de] == $option->id_option)
                                                    selected
                                            @endif>
                                            {{ $option->description }}
                                        </option>
                                    @endforeach
                                </x-select>

                            </div><br/>
                        @elseif(optional($question->question_type)->type == 'Multiple Choice List')
                            <div class='w-100 mt-4'>
                                @foreach ($question->options as $option)
                                    <label>
                                        <input
                                            type="checkbox"
                                            wire:change="toggleOption({{ $question->id_de }}, {{ $option->id_option }})"
                                            value="{{ $option->id_option }}"
                                            @if(in_array($option->id_option, $selectedOptions[$question->id_de] ?? [])) checked @endif
                                        >
                                        {{ $option->description }}
                                    </label>
                                @endforeach
                            </div><br/>
                        @endif
                    @endforeach
                </ul>


                <hr />

                    <p>{{ __('project/conducting.data-extraction.modal.option.select' )}}</p>

                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="To Do" name="btnradio" id="btnradio3" autocomplete="off" @if(!$canEdit) disabled @endif>
                        <label class="btn btn-outline-primary" for="btnradio3">{{ __('project/conducting.data-extraction.modal.option.to_do' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="Done" name="btnradio" id="btnradio1" autocomplete="off" @if(!$canEdit) disabled @endif>
                        <label class="btn btn-outline-primary" for="btnradio1">{{ __('project/conducting.data-extraction.modal.option.done' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="Removed" name="btnradio" id="btnradio6" autocomplete="off" @if(!$canEdit) disabled @endif>
                        <label class="btn btn-outline-primary" for="btnradio6">{{ __('project/conducting.data-extraction.modal.option.removed' )}}</label>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.data-extraction.modal.close' )}}</button>
            </div>
        </div>
    </div>

</div>
<div wire:ignore.self class="modal fade" id="successModalExtraction" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
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
        $wire.on('show-paper-extraction', () => {
            $('#paperModalExtraction').modal('show');
        });
        //mostrar msg de sucesso
        Livewire.on('show-success-extraction', () => {
            $('#paperModalExtraction').modal('hide'); // Hide the paper modal
            $('#successModalExtraction').modal('show'); // Show the success modal
        });

        // fechar modal paper
        $('#successModalExtraction').on('hidden.bs.modal', function () {
            $('#paperModalExtraction').modal('show'); // Reopen the paper modal after success modal is closed
        });
    });
    Livewire.on('reload-paper-extraction', () => {
        // Recarregar o componente Livewire para refletir as mudanças
        Livewire.emit('showPaperExtraction', @json($paper));
    });

    $wire.on('paper-modal', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript

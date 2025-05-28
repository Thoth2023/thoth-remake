<div>
    <div class="modal fade" id="paperModalConflict" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($paper)
                        <h5 class="modal-title" id="paperModalLabel">{{ $paper['title'] }}</h5>
                        <button type="button" data-bs-dismiss="modal" class="btn">
                            <span aria-hidden="true">X</span>
                        </button>
                </div>
                <div class="modal-body mt-0">

                    <span class="pb-0">
                        <h5 >{{ __('project/conducting.study-selection.modal.paper-conflict' )}}</h5>
                        <hr class="py-0 m-0 mt-1 mb-2" style="background: #b0b0b0" />
                    </span>

                    <ul class='list-group'>
                        <li class='list-group-item d-flex'>

                            <div class='w-20 pl-2 '>
                                <b >
                                    {{ __('project/conducting.study-selection.modal.table.conflicts-members' )}}
                                </b>
                            </div>
                            <div class='w-60 pl-2 '>
                                <b >
                                    {!!__('project/conducting.study-selection.modal.table.conflicts-criteria' )!!}
                                </b>
                            </div>
                            <div class='w-20 pl-2 '>
                                <b >
                                    {{ __('project/conducting.study-selection.modal.table.conflicts-status' )}}
                                </b>
                            </div>
                        </li>
                    </ul>
                    <ul class='list-group list-group-flush'>
                        @foreach($membersWithEvaluations as $evaluation)
                            <x-search.item
                                wire:key="{{ $evaluation['member']->user->firstname }} }}"
                                target="search-papers"
                                class="list-group-item d-flex row w-100"
                            >
                            <div class='w-20 pl-2'>
                                <span data-search>{{ $evaluation['member']->user->firstname }} {{ $evaluation['member']->user->lastname }}  ({{ $evaluation['member']->level == 1 ? 'Administrator' : 'Member' }})</span>
                            </div>
                            <div class='w-60 ms-auto'>
                                @if($evaluation['criteria']->isNotEmpty())
                                    <ul>
                                        @foreach($evaluation['criteria'] as $criteria)
                                            <li>{{ $criteria->id }} - {{ $criteria->description }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No criteria selected
                                @endif
                            </div>
                            <div class='w-20 ms-auto'>
                                <b class="{{ 'text-' . strtolower($evaluation['status']) }}">
                                    {{ __("project/conducting.study-selection.status." . strtolower($evaluation['status'])) }}
                                </b>
                            </div>
                            </x-search.item>
                        @endforeach
                    </ul>
                    <hr>
                    <!--
                    <div class="form-group">
                        <label for="note" class="form-control-label">Note</label>
                         <div wire:ignore.self >
                            <div
                                 x-data
                                 x-ref="editorConflict"
                                 x-init="
                                            const quill = new Quill($refs.editorConflict, {
                                                theme: 'snow'
                                            });
                                            // Captura o conteúdo ao sair do campo de edição (blur)
                                            quill.on('text-change', function () {
                                                const content = quill.root.innerHTML;
                                                $wire.set('note', content);
                                            });

                                            // Atualiza o editor quando o conteúdo Livewire mudar
                                            $watch('note', (value) => {
                                                if (quill.root.innerHTML !== value) {
                                                    quill.root.innerHTML = value;
                                                }
                                            });
                                        "
                                 style="height: 70px;">
                                {!! $note !!}
                            </div>
                        </div>
                    </div> -->

                    <div class="d-flex flex-column mt-3">
                    <label>{{ __('project/conducting.study-selection.modal.paper-conflict-note' )}}</label>
                    <textarea
                        id="note"
                        class="form-control"
                        rows="2"
                        wire:model="note"
                        placeholder="{{ __('project/conducting.study-selection.modal.paper-conflict-writer' )}}"
                        required >
                    </textarea>
                    </div>

                    <br/>
                    <p>{{ __('project/conducting.study-selection.modal.option.final-decision' )}}</p>

                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" value="1" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-success" for="btnradio2">{{ __('project/conducting.study-selection.modal.option.accepted' )}}</label>
                        <input type="radio" class="btn-check" wire:model="selected_status" value="2" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-danger" for="btnradio4">{{ __('project/conducting.study-selection.modal.option.rejected' )}}</label>
                    </div>
                        <!-- mensagens de erro para selected_status -->
                        @error('selected_status')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror

                    @if($lastConfirmedBy && $lastConfirmedAt)
                        <div class="mt-3">
                            <span><strong>{{ __('project/conducting.study-selection.modal.last-confirmation') }}:</strong></span>
                            <span> {{ $lastConfirmedBy->user->firstname }} {{ $lastConfirmedBy->user->lastname }}</span>
                            <span>{{ __('project/conducting.study-selection.modal.confirmation-date') }} {{ $lastConfirmedAt->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif

                    @endif
                </div>
                <div class="modal-footer">
                    @if($lastConfirmedBy)
                        <!-- Botão Atualizar quando já houver uma confirmação -->
                        <button type="button" class="btn btn-warning" wire:loading.attr="disabled" wire:click="save">
                            {{ __('project/conducting.study-selection.modal.update' ) }}
                            <div wire:loading>
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    @else
                        <!-- Botão Confirmar quando ainda não houve confirmação -->
                        <button type="button" class="btn btn-success" wire:loading.attr="disabled" wire:click="save">
                            {{ __('project/conducting.study-selection.modal.confirm' ) }}
                            <div wire:loading>
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.study-selection.modal.close' )}}</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="successModalConflict" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">
                        @if (session('successMessage'))
                            {{ __('project/conducting.study-selection.modal.success' )}}
                        @elseif (session('errorMessage'))
                            {{ __('project/conducting.study-selection.modal.error' )}}
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Mensagem de sucesso -->
                    @if (session('successMessage'))
                        <p>{{ session('successMessage') }}</p>
                    @endif

                    <!-- Mensagem de erro -->
                    @if (session('errorMessage'))
                        <p class="text-danger">{{ session('errorMessage') }}</p>
                    @endif
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
        // Show the paper modal
        $wire.on('show-paper-conflict', () => {
            setTimeout(() => {
                $('#paperModalConflict').modal('show');
            }, 800); // Delay to ensure the modal is shown after the paper data is set and the modal is ready
        }); 

        // Show the success modal on success event
        Livewire.on('show-success-conflicts', () => {
            $('#paperModalConflict').modal('hide'); // Hide the paper modal
            $('#successModalConflict').modal('show'); // Show the success modal
        });

        // Handle the closing of success modal to reopen the paper modal
        $('#successModalConflict').on('hidden.bs.modal', function () {
            $('#paperModalConflict').modal('show'); // Reopen the paper modal after success modal is closed
        });
    });
</script>
@endscript

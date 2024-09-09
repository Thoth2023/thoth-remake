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
                    <form wire:submit.prevent="submit">
                    <div class="form-group">
                        <label for="note" class="form-control-label">Note</label>
                        <div wire:ignore>
                            <div x-data
                                 x-ref="editor"
                                 x-init="
                                        const quill = new Quill($refs.editor, {
                                            theme: 'snow'
                                        });
                                        window.addEventListener('submit-note', () => {
                                            const content = quill.root.innerHTML;
                                            $wire.set('note', content); // Atualiza o conteúdo da 'note' no Livewire
                                        });
                                     "
                                 style="height: 70px;">
                                {!! $note !!}
                            </div>
                        </div>
                        @error('note')
                        <span class="text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <p>{{ __('project/conducting.study-selection.modal.option.final-decision' )}}</p>

                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" value="Accepted" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-success" for="btnradio2">{{ __('project/conducting.study-selection.modal.option.accepted' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Rejected" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-danger" for="btnradio4">{{ __('project/conducting.study-selection.modal.option.rejected' )}}</label>

                    </div>
                    </form>

                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" wire:click="submitNote">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.study-selection.modal.close' )}}</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="successModalConflict" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
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
        // Show the paper modal
        $wire.on('show-paper-conflict', () => {
            $('#paperModalConflict').modal('show');
        });
        // Show the success modal on success event
        Livewire.on('show-success', () => {
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

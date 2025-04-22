<div>
    <div class="modal fade" id="paperModalConflictQuality" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($paper)
                        <h5 class="modal-title" id="paperModalLabel">{{ $paper['title'] }}</h5>
                        <button type="button" data-bs-dismiss="modal" class="btn">
                            <span aria-hidden="true">X</span>
                        </button>
                    @endif
                </div>
                <div class="modal-body mt-0">
                    <span class="pb-0">
                        <h5>{{ translationConducting('quality-assessment.resolve.paper-conflict') }}</h5>
                        <hr class="py-0 m-0 mt-1 mb-2" style="background: #b0b0b0" />
                    </span>

                    <ul class='list-group'>
                        <li class='list-group-item d-flex'>
                            <div class='w-30 pl-2'><b>{{ translationConducting('quality-assessment.resolve.table.conflicts-members') }}</b></div>
                            <div class='w-50 pl-2'><b>{{ translationConducting('quality-assessment.resolve.table.conflicts-qa') }}</b></div>
                            <div class='w-20 pl-2'><b>{{ translationConducting('quality-assessment.resolve.table.conflicts-status' )}}</b></div>
                        </li>
                    </ul>

                    <ul class='list-group list-group-flush'>
                        @foreach($membersWithEvaluations as $evaluation)
                            <x-search.item wire:key="{{ $evaluation['firstname'] }}" target="search-papers" class="list-group-item d-flex row w-100">
                                <div class='w-30 pl-2'>
                                    <span>{{ $evaluation['firstname'] }} {{ $evaluation['lastname'] }}
                                    ({{ $evaluation['level'] == 1 ? 'Administrator' : 'Member' }})</span>
                                </div>
                                <div class='w-50 pl-2'>
                                    <ul>
                                        <li>{{ $evaluation['score'] }} / {{ $evaluation['general_score'] }}</li>
                                    </ul>
                                </div>
                                <div class='w-20 ms-auto'>
                                    <b class="{{ 'text-' . strtolower($evaluation['status']) }}">
                                        {{ __("project/conducting.quality-assessment.status." . strtolower($evaluation['status'])) }}
                                    </b>
                                </div>
                            </x-search.item>
                        @endforeach
                    </ul>

                    <div class="d-flex flex-column mt-3">
                        <label>{{ translationConducting('quality-assessment.resolve.paper-conflict-note') }}</label>
                        <textarea id="note" class="form-control" rows="2" wire:model="note" placeholder="{{ translationConducting('quality-assessment.resolve.paper-conflict-writer') }}" required></textarea>
                    </div>

                    <p>{{ translationConducting('quality-assessment.resolve.option.final-decision') }}</p>
                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" value="1" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-success" for="btnradio2">{{ translationConducting('quality-assessment.resolve.option.accepted') }}</label>
                        <input type="radio" class="btn-check" wire:model="selected_status" value="2" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-danger" for="btnradio4">{{ translationConducting('quality-assessment.resolve.option.rejected') }}</label>
                    </div>
                    @error('selected_status')<div class="text-danger mt-2">{{ $message }}</div>@enderror

                    @if($lastConfirmedBy && $lastConfirmedAt)
                        <div class="mt-3">
                            <span><strong>{{ translationConducting('quality-assessment.resolve.last-confirmation') }}:</strong></span>
                            <span>{{ $lastConfirmedBy->user->firstname }} {{ $lastConfirmedBy->user->lastname }}</span>
                            <span>{{ translationConducting('quality-assessment.resolve.confirmation-date') }} {{ $lastConfirmedAt->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if($lastConfirmedBy)
                        <!-- Botão Atualizar quando já houver uma confirmação -->
                        <button type="button" class="btn btn-warning" wire:loading.attr="disabled" wire:click="save">
                            {{ translationConducting('quality-assessment.resolve.update' ) }}
                            <div wire:loading>
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    @else
                        <!-- Botão Confirmar quando ainda não houve confirmação -->
                        <button type="button" class="btn btn-success" wire:loading.attr="disabled" wire:click="save">
                            {{ translationConducting('quality-assessment.resolve.confirm' ) }}
                            <div wire:loading>
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translationConducting('quality-assessment.resolve.close' )}}</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="successModalConflictQuality" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">
                        @if (session('successMessage'))
                            {{ translationConducting('quality-assessment.resolve.success' )}}
                        @elseif (session('errorMessage'))
                            {{ translationConducting('quality-assessment.resolve.error' )}}
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
        $wire.on('show-paper-quality-conflict', () => {
            $('#paperModalConflictQuality').modal('show');
        });
        // Show the success modal on success event
        Livewire.on('show-success-conflicts-quality', () => {
            $('#paperModalConflictQuality').modal('hide'); // Hide the paper modal
            $('#successModalConflictQuality').modal('show'); // Show the success modal
        });

        // Handle the closing of success modal to reopen the paper modal
        $('#successModalConflictQuality').on('hidden.bs.modal', function () {
            $('#paperModalConflictQuality').modal('show'); // Reopen the paper modal after success modal is closed
        });
    });
</script>
@endscript

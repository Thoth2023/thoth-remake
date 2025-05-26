<div class="card">
    <div class="card-header pb-0">
        <x-helpers.modal
            target="question-quality"
            modalTitle="{{ __('project/planning.quality-assessment.general-score.title') }}"
            modalContent="{!! __('project/planning.quality-assessment.general-score.help.content') !!}"
        />
    </div>
    <div class="card-body pb-1">
        <div class="d-flex flex-column gap-2" id="item-container">
            @foreach ($items as $item)
                <div class="d-flex gap-1">
                    <x-input
                        label="Min"
                        type="number"
                        placeholder="0.01"
                        wire:model="items.{{ $loop->index }}.start"
                        min="0"
                        max="{{ $sum }}"
                        disabled="{{ !$loop->first }}"
                        style="min-width: 150px"
                        x-on:keydown="['e', 'E', '+', '-'].includes($event.key) && $event.preventDefault()"
                    />
                    <x-input
                        label="Max"
                        type="number"
                        placeholder="Max"
                        wire:model="items.{{ $loop->index }}.end"
                        wire:blur="updateMax({{ $loop->index }}, $event.target.value)"
                        min="0"
                        max="{{ $sum }}"
                        style="min-width: 150px"
                        disabled="{{ $loop->last }}"
                        x-on:keydown="['e', 'E', '+', '-'].includes($event.key) && $event.preventDefault()"
                    />
                    <div class="btn-group">
                        <x-input
                            wire:model="items.{{ $loop->index }}.description"
                            label="Label"
                            placeholder="Good"
                            class="max-input"
                            pattern="[a-zA-ZÀ-ÿ0-9\s]+"
                            style="
                                min-width: 75px;
                                border-radius: 10px 0 0 10px;
                            "
                        />
                        <button
                            wire:click="updateLabel({{ $loop->index }})"
                            type="button"
                            class="save-button btn btn-secondary"
                            style="
                                max-width: fit-content;
                                margin-top: 1.45rem;
                                padding: 0.6rem 1rem;
                            "
                        >
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex gap-2">
            <div class="btn-group">
                <button
                    type="button"
                    class="btn btn-primary"
                    wire:click="generateIntervals"
                    id="add-item-button"
                    style="max-width: fit-content; margin-top: 1rem"
                >
                    <i class="fa fa-plus mr"></i>
                    {{ __("project/planning.quality-assessment.generate-intervals") }}
                </button>
                <x-input
                    type="number"
                    placeholder="Max"
                    wire:model="intervals"
                    min="2"
                    max="10"
                    style="
                        min-width: 75px;
                        margin-top: 0.75rem;
                        border-radius: 0 10px 10px 0;
                    "
                />
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('qa-ranges', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript

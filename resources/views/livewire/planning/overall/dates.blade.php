<div class="card">
    <div class="card-header thoth-card-header mb-0 pb-0">

        <!-- Badge numérico moderno -->
        <div class="thoth-card-badge"><b>5</b></div>
        <x-helpers.modal
            target="search-domains"
            modalTitle="{{ __('project/planning.overall.dates.help.title') }}"
            modalContent="{{ __('project/planning.overall.dates.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="d-flex flex-column gap-2 form-group">
                <x-input
                    wire:model="startDate"
                    type="date"
                    label="{{ __('project/planning.overall.dates.start_date') }}"
                    required
                />
                @error("startDate")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <x-input
                    wire:model="endDate"
                    type="date"
                    label="{{ __('project/planning.overall.dates.end_date') }}"
                    required
                />
                @error("endDate")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button>
                    {{ __("project/planning.overall.dates.add_date") }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </div>
        </form>
        <div id="message"></div>
    </div>
</div>

@script
    <script>
        $wire.on('dates', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript

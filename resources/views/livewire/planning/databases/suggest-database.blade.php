<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header thoth-card-header mb-0 pb-0">

            <!-- Badge numérico moderno -->
            <div class="thoth-card-badge"><b>8</b></div>
            <x-helpers.modal
                target="suggest-database"
                modalTitle="{{ __('project/planning.databases.suggest-new.help.title') }}"
                modalContent="{!!  __('project/planning.databases.suggest-new.help.content')  !!}"
            />
        </div>
        <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group">
                <div class="d-flex gap-3 flex-column w-100 w-md-50">
                    <div>
                        <x-input
                            label="{{ __('project/planning.databases.suggest-new.name-label') }}"
                            id="suggest"
                            wire:model="suggest"
                            placeholder="{{ __('project/planning.databases.suggest-new.enter-name') }}"
                        />
                        @error("suggest")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <x-input
                            label="{{ __('project/planning.databases.suggest-new.link-label')}}"
                            id="link"
                            wire:model="link"
                            placeholder="{{ __('project/planning.databases.suggest-new.enter-link') }}"
                        />
                        @error("link")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="align-self">
                        <x-helpers.submit-button class="mb-0">
                            {{ __("project/planning.databases.suggest-new.submit-button") }}
                        </x-helpers.submit-button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('suggest-database', ([{ message, type }]) => {
            toasty({ message, type });
            console.log(message, type);
        });
    </script>
@endscript

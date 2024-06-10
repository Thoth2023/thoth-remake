<div class="card">
    <div class="card-body">
        <h4 class="mb-3 text-lg text-bold">
            {{ __("project/planning.databases.suggest-new.title") }}
        </h4>
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

@script
    <script>
        $wire.on('suggest-database', ([{ message, type }]) => {
            toasty({ message, type });
            console.log(message, type);
        });
    </script>
@endscript

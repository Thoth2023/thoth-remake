<?php

use App\Traits\ProjectPermissions;

?>

<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="search-strategy"
            modalTitle="{{ __('project/planning.search-strategy.title') }}"
            modalContent="{!!  __('project/planning.search-strategy.help.content') !!}"
        />
    </div>

    <div class="card-body">
        @if (session()->has("message"))
            <div
                class="alert alert-{{ session("message_type") }} alert-dismissible fade show"
                role="alert"
            >
                {{ session("message") }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form wire:submit.prevent="submit">
            <div class="d-flex flex-column">
                <label
                    for="search-strategy-description"
                    class="form-control-label mx-0 mb-1 required"
                >
                    {{ __("project/planning.research-questions.form.description") }}
                </label>
                <div wire:ignore>
                    <div x-data
                         x-ref="editor"
                         x-init="
                            const quill = new Quill($refs.editor, {
                            theme: 'snow'
                            });
                                quill.on('text-change', function () {
                                    // Obtém o texto puro (sem tags HTML)
                                    const plainText = quill.getText().trim();

                                    // Remove espaços extras e define o valor no Livewire
                                    $wire.set('currentDescription', plainText);
                                });
                            "
                             style="height: 250px;">
                        {!! $currentDescription !!}
                    </div>
                </div>
            </div>
            @error("currentDescription")
            <span class="text-xs text-danger">
                    {{ $message }}
                </span>
            @enderror

            <div class="d-flex align-items-center mt-4">
                <button
                    type="submit"
                    class="btn btn-success mt-3"
                    wire:loading.attr="disabled"
                    {{ !$this->userCanEdit() ? 'disabled' : '' }}
                >
                    {{ __("project/planning.search-strategy.save-button") }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>

@script
<script>
    $wire.on('search-strategy', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript

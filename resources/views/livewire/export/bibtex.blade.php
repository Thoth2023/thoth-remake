<div style="height: 620px;" class="card my-2 p-2">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="bibtex"
            modalTitle="{{ translationExport('header.bibtex.title') }}"
            modalContent="{!! translationExport('header.bibtex.help-content') !!}"
        />
    </div>

    <div class="d-flex flex-column mb-2">
        <div class="d-flex flex-column mt-1">
            <div>
                <label>
                    <input
                        type="radio"
                        name="options"
                        value="study_selection"
                        wire:model="selectedOption"
                        wire:change="generateBibtex"
                    >
                    Study Selection
                </label>
                <label>
                    <input
                        type="radio"
                        name="options"
                        value="quality_assessment"
                        wire:model="selectedOption"
                        wire:change="generateBibtex"
                    >
                    Quality Assessment
                </label>
                <label>
                    <input
                        type="radio"
                        name="options"
                        value="snowballing"
                        wire:model="selectedOption"
                        wire:change="generateBibtex"
                    >
                    Snowballing
                </label>
            </div>
            <textarea
                class="form-control overflow-auto mt-3"
                style="height: 400px;"
                id="description"
                wire:model="description_bibtex"
                placeholder="{{ translationExport('header.bibtex.enter_description') }}"
                readonly
            ></textarea>
        </div>
    </div>

    <div class="align-self-center mt-1">
        <button
            type="button"
            class="btn btn-dark mb-0"
            wire:click="downloadBibtex"
        >
            <i class="fas fa-download"></i>
            {{ __("project/export.button.bibtex-download") }}
        </button>
    </div>
</div>

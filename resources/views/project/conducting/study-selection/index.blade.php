@if (session()->has('error'))
    <div class='card card-body col-md-12 mt-3'>
        <h3 class="h4 mb-3">Complete these tasks to advance</h3>
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    </div>
@else
    <div class='card card-body col-md-12 mt-3'>
    <div class="d-flex flex-column gap-4">

            <div class="card">
                <div class="card-header mb-0 pb-4">
                    <x-helpers.modal
                        target="import-studies"
                        modalTitle="{{ __('project/conducting.study-selection.title') }}"
                        modalContent="{{ __('project/conducting.study-selection.help.content') }}"
                    />
                </div>
            </div>
    </div>

        <div>
            @livewire('conducting.study-selection.count')
        </div>
        <div class="buttons-section mb-3">
            @livewire('conducting.study-selection.buttons')
        </div>
        <div class="table-section">
           @livewire('conducting.study-selection.table')
        </div>
    </div>
@endif

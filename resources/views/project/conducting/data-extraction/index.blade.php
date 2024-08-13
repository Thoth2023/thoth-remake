@if (session()->has('error'))
    <div class='card card-body col-md-12 mt-3'>
        <h3 class="h4 mb-3">Complete these tasks to advance</h3>
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    </div>
@else
    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="quality-assessment"
                modalTitle="{{ __('project/conducting.data-extraction.title') }}"
                modalContent="{{ __('project/conducting.data-extraction.help.content') }}"
            />
        </div>
        <br/>
        <div>
            @livewire('conducting.data-extraction.count')
        </div>
        <div class="table-section">
            @livewire('conducting.data-extraction.table')
        </div>


    </div>

@endif

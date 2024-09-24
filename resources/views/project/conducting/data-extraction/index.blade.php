
    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="quality-assessment"
                modalTitle="{{ __('project/conducting.data-extraction.title') }}"
                modalContent="{!! __('project/conducting.data-extraction.help.content') !!} "
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



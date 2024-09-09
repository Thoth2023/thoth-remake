
    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="quality-assessment"
                modalTitle="{{ __('project/conducting.quality-assessment.title') }}"
                modalContent="{{ __('project/conducting.quality-assessment.help.content') }}"
            />
        </div>
        <br/>
        <div>
            @livewire('conducting.quality-assessment.count')
        </div>
        <div class="table-section">
            @livewire('conducting.quality-assessment.table')
        </div>


    </div>



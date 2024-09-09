
    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="study-selection"
                modalTitle="{{ __('project/conducting.study-selection.title') }}"
                modalContent="{{ __('project/conducting.study-selection.help.content') }}"
            />
        </div>
        <br/>
        <div>
            @livewire('conducting.study-selection.count')
        </div>
        <div class="table-section">
            @livewire('conducting.study-selection.table')
        </div>


    </div>



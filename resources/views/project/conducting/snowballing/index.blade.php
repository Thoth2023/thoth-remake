
    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="snowballing"
                modalTitle="{{ __('project/conducting.snowballing.title') }}"
                modalContent="{{ __('project/conducting.snowballing.help.content') }}"
            />
        </div>
        <br/>
        <div>
            @livewire('conducting.snowballing.count')
        </div>
        <div class="table-section">
            @livewire('conducting.snowballing.table')
        </div>


    </div>



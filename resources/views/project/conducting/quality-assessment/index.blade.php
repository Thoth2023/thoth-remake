
    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="quality-assessment"
                modalTitle="{{ translationConducting('quality-assessment.title') }}"
                modalContent="{!!  translationConducting('quality-assessment.help.content')!!} "
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



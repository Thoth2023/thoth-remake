@props(['$papers'])

<div class='card card-body col-md-12 mt-3'>
    <div class="d-flex justify-content-between align-items-center mb-3">
        @livewire("conducting.study-selection.buttons")
    </div>
    @livewire("conducting.study-selection.table")
</div>
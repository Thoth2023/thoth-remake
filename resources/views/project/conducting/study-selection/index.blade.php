@props(['$studies', '$project'])

<div class='card card-body col-md-12 mt-3'>
    @livewire("conducting.study-selection.search", ['projectId' => $project->id])
    <div class='progress mt-4'>
        <div  class="progress-bar col-md-6" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    @livewire("conducting.study-selection.table")
</div>
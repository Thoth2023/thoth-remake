<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-group justify-content-center">
            @livewire("planning.overall.domains")
            @livewire("planning.overall.languages")
            @include("project.planning.overall.study-type")
            @include("project.planning.overall.keywords")
            @include("project.planning.overall.dates")
        </div>
    </div>
</div>

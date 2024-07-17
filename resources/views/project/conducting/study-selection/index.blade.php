@if (session()->has('error'))
    <div class='card card-body col-md-12 mt-3'>
        <h3 class="h4 mb-3">Complete these tasks to advance</h3>
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    </div>
@else
    <div class='card card-body col-md-12 mt-3'>
        <h1 class="h4 mb-3">Study Selection</h1>
        <div>
            @livewire('conducting.study-selection.count')
        </div>
        <div class="buttons-section mb-3">
            @livewire('conducting.study-selection.buttons')
        </div>
        <div class="search-section mb-3">
            @livewire('conducting.study-selection.search')
        </div>
        <div class="table-section">
            @livewire('conducting.study-selection.table')
        </div>
    </div>
@endif

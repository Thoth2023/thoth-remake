<div>
    <br/>
    <div class="row">
        <div class="col-4">
            <x-search.input class="form-control" target="search-papers" wire:model.debounce.500ms="search" placeholder="{{ __('project/conducting.quality-assessment.buttons.search-papers' )}}" aria-label="Search" />
        </div>
        <div class="col-8 text-end">
            @livewire('conducting.quality-assessment.buttons')
        </div>
    </div>
    <ul class='list-group'>
        <li class='list-group-item d-flex'>

            <div class='w-5 pl-2'>
                <b wire:click.prevent="sortBy('id')" role="button">
                    {{ __('project/conducting.quality-assessment.table.id' )}}
                    @if(isset($sorts['id']))
                        @if($sorts['id'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='w-50 pl-2 pr-2'>
                <b wire:click.prevent="sortBy('title')" role="button">
                    {{ __('project/conducting.quality-assessment.table.title' )}}
                    @if(isset($sorts['title']))
                        @if($sorts['title'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='w-15 pl-2 ms-auto'>
                <b wire:click.prevent="sortBy('general_score')" role="button">
                    {{ __('project/conducting.quality-assessment.table.general-score' )}}
                    @if(isset($sorts['general_score']))
                        @if($sorts['general_score'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='w-10 pl-2 ms-auto'>
                <b wire:click.prevent="sortBy('score')" role="button">
                    {{ __('project/conducting.quality-assessment.table.score' )}}
                    @if(isset($sorts['score']))
                        @if($sorts['score'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>

            <div class='pr-5 w-15 ms-auto'>
                <b wire:click.prevent="sortBy('status')" role="button">
                    {{ __('project/conducting.quality-assessment.table.status') }}
                    @if(isset($sorts['status']))
                        @if($sorts['status'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
        </li>
    </ul>
    @livewire('conducting.quality-assessment.paper-modal')
    <ul class='list-group list-group-flush'>
        @forelse ($papers as $paper)
            <x-search.item
                wire:key="{{ $paper['title'] }}"
                target="search-papers"
                class="list-group-item d-flex row w-100"
            >
                <div class='w-5 pl-2'>
                    <span data-search>{{ $paper['id'] }}</span>
                </div>
                <div class='w-50' role='button' wire:click="openPaper({{ $paper }})">
                    <span data-search>{{ $paper['title'] }}</span>
                </div>
                <div class='w-15 ms-auto'>
                    <span data-search>{{ $paper['general_score'] }}</span>
                </div>
                <div class='w-10 ms-auto'>
                    <span data-search>{{ $paper['score'] }}</span>
                </div>

                <div class="w-15 ms-auto">
                    <b data-search class="{{ 'text-' . strtolower($paper['status_description']) }}">
                        {{ __("project/conducting.quality-assessment.status." . strtolower($paper['status_description'])) }}
                    </b>
                </div>
            </x-search.item>
        @empty
            <x-helpers.description>
                {{ __("project/conducting.quality-assessment.papers.empty")}}
            </x-helpers.description>
        @endforelse
        <x-search.empty target="search-papers">
            {{ __("project/conducting.quality-assessment.papers.no-results") }}
        </x-search.empty>
    </ul>
    <br/>

    <div class="d-flex ms-auto" style="width: 70%;">
        <span class="ms-auto" style="width: 10%;"> {{ __('project/conducting.quality-assessment.buttons.filter-by' )}}:</span>
        <select class="form-select me-2" style="width: 25%; margin-bottom: 0rem" wire:model="selectedStatus">
            <option value="">{{ __('project/conducting.quality-assessment.buttons.select-status' )}}</option>
            @foreach($statuses as $id => $description)
                <option value="{{ $id }}">{{ __("project/conducting.quality-assessment.status." . strtolower($description)) }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary ms-2" style="margin-bottom: 0rem" wire:click="applyFilters">{{ __('project/conducting.quality-assessment.buttons.filter' )}}</button>
    </div>
    <br/>
    {{ $papers->links() }}
</div>
@script
<script>
    $wire.on('table', ([{ message, type }]) => {
        toasty({ message, type });
    });
    $wire.on('paperSaved', ([{ message, type }]) => {
        toasty({ message, type });
        @this.call('refreshPapers');
    });
</script>
@endscript

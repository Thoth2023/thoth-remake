@php
    $studySelectionPath = 'project/conducting.study-selection';
@endphp

<div>
    <br/>
    <div class="row">
        <div class="col-4 d-flex">
            <x-search.input class="form-control me-2" target="search-papers-selection" wire:model.debounce.500ms="search" placeholder="{{ translationConducting("study-selection.buttons.search-papers")}}" aria-label="Search" />
        </div>
        <div class="col-8 text-end">
            @livewire('conducting.study-selection.buttons')
        </div>
    </div>
    <ul class='list-group'>
        <li class='list-group-item d-flex'>

            <div class='w-10 pl-2'>
                <b wire:click.prevent="sortBy('id')" role="button">
                    {{ translationConducting("study-selection.table.id")}}
                    @if(isset($sorts['id']))
                        @if($sorts['id'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='w-55 pl-2 pr-2'>
                <b wire:click.prevent="sortBy('title')" role="button">
                    {{ translationConducting("study-selection.table.title")}}
                    @if(isset($sorts['title']))
                        @if($sorts['title'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>

            <div class='w-20 pl-2 pr-2 ms-auto'>
                <b wire:click.prevent="sortBy('database')" role="button">
                    {{ translationConducting("study-selection.table.database")}}
                    @if(isset($sorts['database']))
                        @if($sorts['database'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='pr-5 w-15 ms-auto'>
                <b wire:click.prevent="sortBy('status')" role="button">
                    {{ translationConducting("study-selection.table.status") }}
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
    @livewire('conducting.study-selection.paper-modal')
    @livewire('conducting.study-selection.paper-modal-conflicts')
    <ul class='list-group list-group-flush'>
        @forelse ($papers as $paper)
            <x-search.item
                wire:key="{{ $paper['title'] }}"
                target="search-papers-selection"
                class="list-group-item d-flex row w-100"
            >
                <div class='w-10 pl-2'>
                    <span data-search>{{ $paper['id'] }}</span>
                </div>
                <div class='w-55' role='button' wire:click.prevent="openPaper({{ $paper }})">
                    <span data-search>{{ $paper['title'] }}</span>
                </div>

                <div class='w-20 ms-auto'>
                    <span data-search>{{ $paper['database_name'] }}</span>
                </div>
                <div class="w-15 ms-auto">
                    <b data-search class="{{ 'text-' . strtolower($paper['status_description']) }}">
                        {{ translationConducting('study-selection.status." . strtolower($paper['status_description'])) }}
                    </b>
                    @if($isAdministrator)
                        @if($paper->has_conflict && !$paper->is_confirmed)
                            <!-- Mostrar div de resolução de conflitos -->
                            <div class="badge bg-warning text-white" role="button" wire:click.prevent="openConflictModal({{ $paper }})" title="Resolve Conflicts">
                                <i class="fa-solid fa-file-circle-exclamation"></i> Resolve
                            </div>
                        @elseif($paper->has_conflict && $paper->is_confirmed)
                            <!-- já resolvidos -->
                            <div class="badge bg-light text-dark" role="button" wire:click.prevent="openConflictModal({{ $paper }})" title="Conflicts Resolved">
                                <i class="fa-solid fa-check-circle"></i> ok
                            </div>
                        @endif
                    @endif

                </div>
            </x-search.item>
        @empty
            <x-helpers.description>
                {{ translationConducting('study-selection.papers.empty")}}
            </x-helpers.description>
        @endforelse
        <x-search.empty target="search-papers">
            {{ translationConducting('study-selection.papers.no-results") }}
        </x-search.empty>
    </ul>
    <br/>

    <div class="d-flex ms-auto" style="width: 70%;">
        <span class="ms-auto" style="width: 10%;"> {{ translationConducting("study-selection.buttons.filter-by")}}:</span>
        <select class="form-select me-2" style="width: 40%;" wire:model="selectedDatabase">
            <option value="">{{ translationConducting("study-selection.buttons.select-database")}}</option>
            @foreach($databases as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <select class="form-select me-2" style="width: 25%; margin-bottom: 0rem" wire:model="selectedStatus">
            <option value="">{{ translationConducting("study-selection.buttons.select-status")}}</option>
            @foreach($statuses as $id => $description)
                <option value="{{ $id }}">{{ translationConducting('study-selection.status." . strtolower($description)) }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary ms-2" style="margin-bottom: 0rem" wire:click="applyFilters">{{ translationConducting("study-selection.buttons.filter")}}</button>
    </div>
    <br/>
    {{ $papers->links() }}
</div>
@script
<script>
    $wire.on('table', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript

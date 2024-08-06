<div>
    <div class="d-flex input-group justify-self-end" style="width: 30%;">
        <x-search.input class="form-control" target="search-papers" wire:model.debounce.500ms="search" placeholder="Search..." aria-label="Search" />
    </div>

    <ul class='list-group'>
        <li class='list-group-item d-flex'>

            <div class='w-5 pl-2'>
                <b wire:click.prevent="sortBy('id')" role="button">
                    {{ __('project/conducting.study-selection.table.id' )}}
                    @if(isset($sorts['id']))
                        @if($sorts['id'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='w-60 pl-2 pr-2'>
                <b wire:click.prevent="sortBy('title')" role="button">
                    {{ __('project/conducting.study-selection.table.title' )}}
                    @if(isset($sorts['title']))
                        @if($sorts['title'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>

            <div class='w-15 pl-2 pr-2'>
                <b wire:click.prevent="sortBy('database')" role="button">
                    {{ __('project/conducting.study-selection.table.database') }}
                    @if(isset($sorts['database']))
                        @if($sorts['database'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='pr-5 w-15'>
                <b wire:click.prevent="sortBy('status')" role="button">
                    {{ __('project/conducting.study-selection.table.status') }}
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
                <div class='w-60' role='button' wire:click.prevent="openPaper({{ $paper }})">
                    <span data-search>{{ $paper['title'] }}</span>
                </div>

                <div class='w-15'>
                    <span data-search>{{ $paper['database_name'] }}</span>
                </div>
                <div class='w-15'>
                    <b data-search>
                        {{ $paper['status_description'] }}
                    </b>
                </div>
            </x-search.item>
        @empty
            <x-helpers.description>
                {{ __("project/conducting.study-selection.papers.empty")}}
            </x-helpers.description>
        @endforelse
        <x-search.empty target="search-papers">
            {{ __("project/conducting.study-selection.papers.no-results") }}
        </x-search.empty>
    </ul>
    <br/>

    <div class="d-flex ms-auto" style="width: 60%;">
        <span class="ms-auto" style="width: 10%;"> Filtrar por:</span>
        <select class="form-select me-2" style="width: 25%;" wire:model="selectedDatabase">
            <option value="">{{ __('Selecione Database') }}</option>
            @foreach($databases as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <select class="form-select me-2" style="width: 25%;" wire:model="selectedStatus">
            <option value="">{{ __('Selecione o Status') }}</option>
            @foreach($statuses as $id => $description)
                <option value="{{ $id }}">{{ $description }}</option>
            @endforeach
        </select>
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

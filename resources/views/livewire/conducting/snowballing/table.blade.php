<div>
    <br/>
    <div class="row">
        <div class="col-4">
            <x-search.input class="form-control" target="search-papers" wire:model.debounce.500ms="search" placeholder="{{ translationConducting('snowballing.buttons.search-papers' )}}" aria-label="Search" />
        </div>
        <div class="col-8 text-end">
            @livewire('conducting.snowballing.buttons')
        </div>
    </div>
    <ul class='list-group'>
        <li class='list-group-item d-flex'>

            <div class='w-10 pl-2'>
                <b wire:click.prevent="sortBy('id')" role="button">
                    {{ translationConducting('snowballing.table.id' )}}
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
                    {{ translationConducting('snowballing.table.title' )}}
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
                <b wire:click.prevent="sortBy('year')" role="button">
                    {{ translationConducting('snowballing.table.year') }}
                    @if(isset($sorts['year']))
                        @if($sorts['year'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='pr-5 w-15 ms-auto'>
                <b wire:click.prevent="sortBy('status')" role="button">
                    {{ translationConducting('snowballing.table.status') }}
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
    @livewire('conducting.snowballing.paper-modal')
    <ul class='list-group list-group-flush'>
        @forelse ($papers as $paper)
            <x-search.item
                wire:key="{{ $paper['title'] }}"
                target="search-papers"
                class="list-group-item d-flex row w-100"
            >
                <div class='w-10 pl-2'>
                    <span data-search>{{ $paper['id'] }}</span>
                </div>
                <div class='w-55' role='button' wire:click.prevent="openPaper({{ $paper }})">
                    <span data-search>{{ $paper['title'] }}</span>
                </div>

                <div class='w-20 ms-auto'>
                    <span data-search>{{ $paper['year'] }}</span>
                </div>
                <div class="w-15 ms-auto">
                    <b data-search class="{{ 'text-' . strtolower($paper['status_description']) }}">
                        {{ translationConducting('snowballing.status.' . strtolower($paper['status_description'])) }}
                    </b>
                    <!-- Exibir o ícone de exclamação se aceito em "Avaliação por Pares" -->
                    @if($paper->peer_review_accepted)

                        <i class="fa-solid fa-users" title=" {{ translationConducting('quality-assessment.resolve.resolved-decision') }}"></i>

                    @endif
                </div>
            </x-search.item>
        @empty
            <x-helpers.description>
                {{ translationConducting('snowballing.papers.empty')}}
            </x-helpers.description>
        @endforelse
        <x-search.empty target="search-papers">
            {{ translationConducting('snowballing.papers.no-results') }}
        </x-search.empty>
    </ul>
    <br/>

    <div class="d-flex ms-auto" style="width: 70%;">
        <span class="ms-auto" style="width: 10%;"> {{ translationConducting('snowballing.buttons.filter-by' )}}:</span>

        <select class="form-select me-2" style="width: 25%; margin-bottom: 0rem" wire:model="selectedStatus">
            <option value="">{{ translationConducting('snowballing.buttons.select-status' )}}</option>
            @foreach($statuses as $id => $description)
                <option value="{{ $id }}">{{ translationConducting('snowballing.status.' . strtolower($description)) }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary ms-2" style="margin-bottom: 0rem" wire:click="applyFilters">{{ translationConducting('snowballing.buttons.filter' )}}</button>
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

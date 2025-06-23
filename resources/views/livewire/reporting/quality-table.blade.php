<div>
    <br/>
    <div class="row">
        <div class="col-4">
            <x-search.input class="form-control" target="search-papers" wire:model.debounce.500ms="search" placeholder="{{ translationConducting('quality-assessment.buttons.search-papers' )}}" aria-label="Search" />
        </div>
        <div class="col-8 text-end">
            @livewire('conducting.quality-assessment.buttons')
        </div>
    </div>
    <ul class='list-group'>
        <li class='list-group-item d-flex'>

            <div class='w-5 pl-2'>
                <b wire:click.prevent="sortBy('id')" role="button">
                    {{ translationConducting('quality-assessment.table.id' )}}
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
                    {{ translationConducting('quality-assessment.table.title' )}}
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
                    {{ translationConducting('quality-assessment.table.general-score' )}}
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
                    {{ translationConducting('quality-assessment.table.score' )}}
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
                    {{ translationConducting('quality-assessment.table.status') }}
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
                <div class='w-50'>
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
                        {{ translationConducting('quality-assessment.status.' . strtolower($paper['status_description'])) }}
                    </b>
                    <!-- Exibir o ícone de exclamação se aceito em "Avaliação por Pares" -->
                    @if($paper->peer_review_accepted)

                            <i class="fa-solid fa-users" title=" {{ translationConducting('quality-assessment.resolve.resolved-decision') }}"></i>

                    @endif
                    @if($isAdministrator)
                        @if($paper->has_conflict && !$paper->is_confirmed)
                            <!-- Mostrar div de resolução de conflitos -->
                            <div class="badge bg-warning text-white"  title="Resolve Conflicts">
                                <i class="fa-solid fa-file-circle-exclamation"></i> Resolve
                            </div>
                        @elseif($paper->has_conflict && $paper->is_confirmed)
                            <!-- já resolvidos -->
                            <div class="badge bg-light text-dark"   title="Conflicts Resolved">
                                <i class="fa-solid fa-check-circle"></i> ok
                            </div>
                        @endif
                    @endif

                </div>
            </x-search.item>
        @empty
            <x-helpers.description>
                {{ translationConducting('quality-assessment.papers.empty')}}
            </x-helpers.description>
        @endforelse
        <x-search.empty target="search-papers">
            {{ translationConducting('quality-assessment.papers.no-results') }}
        </x-search.empty>
    </ul>
    <br/>

    <div class="d-flex ms-auto" style="width: 70%;">
        <span class="ms-auto" style="width: 10%;"> {{ translationConducting('quality-assessment.buttons.filter-by' )}}:</span>
        <select class="form-select me-2" style="width: 25%; margin-bottom: 0rem" wire:model="selectedStatus">
            <option value="">{{ translationConducting('quality-assessment.buttons.select-status' )}}</option>
            @foreach($statuses as $id => $description)
                <option value="{{ $id }}">{{ translationConducting('quality-assessment.status.' . strtolower($description)) }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary ms-2" style="margin-bottom: 0rem" wire:click="applyFilters">{{ translationConducting('quality-assessment.buttons.filter' )}}</button>
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

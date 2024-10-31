<div>
    <br/>
    <div class="row">
        <div class="col-4 d-flex">
            <x-search.input class="form-control me-2" target="search-papers-selection" wire:model.debounce.500ms="search" placeholder="{{ __('project/conducting.study-selection.buttons.search-papers' )}}" aria-label="Search" />
        </div>
        <div class="col-8 text-end">
            @livewire('reporting.peer-review-selection-buttons')
        </div>
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
            <div class='w-40 pl-2 pr-2'>
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

            <!-- Cabeçalhos dinâmicos para os membros -->
            @if($papers->isNotEmpty() && $papers->first()->statuses_by_member)
                @foreach($papers->first()->statuses_by_member->pluck('member_name')->unique() as $memberName)
                    <div class='pr-5 w-15 ms-auto'>
                        {{ __('project/reporting.reliability.pesquisador') }} #{{ $loop->iteration }}<br> <b>{{ $memberName }}</b>
                    </div>
                @endforeach
            @endif

            <div class='pr-5 w-15 ms-auto'>
                <b wire:click.prevent="sortBy('status')" role="button">
                    Avaliação por pares / Revisor
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
            <x-search.item wire:key="{{ $paper['title'] }}" target="search-papers-selection" class="list-group-item d-flex row w-100">
                <!-- Coluna ID e Título -->
                <div class='w-5 pl-2'>
                    <span data-search>{{ $paper['id'] }}</span>
                </div>
                <div class='w-40'>
                    <span data-search>{{ $paper['title'] }}</span>
                </div>

                <!-- Colunas para cada membro e seus status -->
                @foreach ($paper->statuses_by_member as $member)
                    <div class='w-15 ms-auto'>
                        <b data-search class="{{ 'text-' . strtolower($member->status_description) }}">
                            {{ __("project/conducting.study-selection.status." . strtolower($member->status_description)) }}
                        </b>
                    </div>
                @endforeach

                <!-- Coluna de Avaliação por Pares -->
                <div class="w-15 ms-auto">
                    <b data-search class="{{ $paper->peer_review_decision ? 'text-' . strtolower($paper->peer_review_decision->new_status_paper == 1 ? 'accepted' : 'rejected') : 'text-default' }}">
                        @if($paper->peer_review_decision)
                            {{ __("project/conducting.study-selection.status." . ($paper->peer_review_decision->new_status_paper == 1 ? 'accepted' : 'rejected')) }}
                        @else
                            -
                        @endif
                    </b>
                </div>
            </x-search.item>
        @empty
            <x-helpers.description>
                {{ __("project/conducting.study-selection.papers.empty") }}
            </x-helpers.description>
        @endforelse
    </ul>
    <br/>
    {{ $papers->links() }}
</div>
@script
<script>
    $wire.on('peer-review-selection-table', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript

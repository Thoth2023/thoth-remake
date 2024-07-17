<div>
    <ul class='list-group'>
        <li class='list-group-item d-flex'>
            <div class='w-5 pl-2'>
                <b wire:click.prevent="sortBy('id')" role="button" href="#">
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
            <div class='w-20 pl-2 pr-2'>
                <b wire:click.prevent="sortBy('title')" role="button" href="#">
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
            <div class='w-20'>
                <b wire:click.prevent="sortBy('ac')" role="button" href="#">
                    {{ __('project/conducting.study-selection.table.acceptance-criteria' )}}
                    @if(isset($sorts['ac']))
                        @if($sorts['ac'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='w-20 pl-2 pr-2'>
                <b wire:click.prevent="sortBy('ec')" role="button" href="#">
                    {{ __('project/conducting.study-selection.table.rejection-criteria' )}}
                    @if(isset($sorts['ec']))
                        @if($sorts['ec'] === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </b>
            </div>
            <div class='w-15 pl-2 pr-2'>
                <b wire:click.prevent="sortBy('database')" role="button" href="#">
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
                <b wire:click.prevent="sortBy('status')" role="button" href="#">
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
            <div class='w-5'>
                <b>
                    {{ __('project/conducting.study-selection.table.actions') }}
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
                    <b data-search>{{ $paper['id_paper'] }}</b>
                </div>
                <div class='w-20' role='button' wire:click.prevent="openPaper({{ $paper }})">
                    <b data-search>{{ $paper['title'] }}</b>
                </div>
                <div class='w-20'>
                    <b data-search>[wip]</b>
                </div>
                <div class='w-20'>
                    <b data-search>[wip]</b>
                </div>
                <div class='w-15'>
                    <b data-search>{{ $paper['data_base'] }}</b>
                </div>
                <div class='w-15'>
                    <b data-search>
                        {{ $paper->status }}
                    </b>
                </div>
                <a class='btn btn-light w-5' href="{{ $paper->url }}" wire:custom-directive>
                    <i class="fa fa-solid fa-share"></i>
                </a>
            </x-search.item>
            @empty
            <x-helpers.description>
                {{ __("project/conducting.study-selection.papers.empty")}}
            </x-helpers.description>
        @endforelse
        <x-search.empty target="search-papers" >
            {{ __("project/conducting.study-selection.papers.no-results") }}
        </x-search.empty>

    </ul>
</div>


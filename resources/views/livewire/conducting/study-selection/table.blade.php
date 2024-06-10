<div>
    <div class="progress mb-3">
        <div class="progress-bar" role="progressbar" style="width: {{ count($papers) ? (count($papers->where('status', 'Accepted')) / count($papers) * 100) : 0 }}%;" aria-valuenow="{{ count($papers) ? (count($papers->where('status', 'Accepted')) / count($papers) * 100) : 0 }}" aria-valuemin="0" aria-valuemax="100">Progress Study Selection</div>
    </div>
    @livewire("conducting.study-selection.search")
    <ul class='list-group'>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-1'>
                    <b wire:click="sortBy('id')" role="button" href="#">
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
                <div class='col'>
                    <b wire:click="sortBy('title')" role="button" href="#">
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
                <div class='col'>
                    <b wire:click="sortBy('ac')" role="button" href="#">
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
                <div class='col'>
                    <b wire:click="sortBy('ec')" role="button" href="#">
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
                <div class='col-2'>
                    <b wire:click="sortBy('database')" role="button" href="#">
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
                <div class='col-1'>
                    <b wire:click="sortBy('status')" role="button" href="#">
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
            </div>
        </li>
    </ul>
    <ul class='list-group list-group-flush'>
        @forelse ($papers as $paper)
            <x-search.item
                wire:key="{{ $paper['id_paper'], $paper['title'], $paper['data_base'], $paper['status']}}"
                target="search-papers"
                class="list-group-item d-flex row"
            >
                <div class='w-3'>
                    <b>{{ $paper['id_paper'] }}</b>
                </div>
                <div class='w-5'>
                    <b>{{ $paper['title'] }}</b>
                </div>
                <div class='w-5'>
                    <b>[wip]</b>
                </div>  
                <div class='w-5'>
                    <b>[wip]</b>
                </div>
                <div class='w-5'>
                    <b>{{ $paper['data_base'] }}</b>
                </div>
                <div class=''>
                    @if(isset($editingStatus[$paper->id]))
                        <select wire:model="editingStatus.{{ $paper->id }}" wire:change="updateStatus({{ $paper->id }}, $event.target.value)">
                            @foreach($statuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    @else
                        <option wire:click="$set('editingStatus.{{ $paper->id }}', '{{ $paper->status }}')">
                            {{ $paper->status }}
                        </option>
                    @endif
                </div>
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
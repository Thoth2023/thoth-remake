<div>
    <div class="progress mb-3">
        <div class="progress-bar" role="progressbar" style="width: {{ count($papers) ? (count($papers->where('status', 'Accepted')) / count($papers) * 100) : 0 }}%;" aria-valuenow="{{ count($papers) ? (count($papers->where('status', 'Accepted')) / count($papers) * 100) : 0 }}" aria-valuemin="0" aria-valuemax="100">Progress Study Selection</div>
    </div>
    @livewire("conducting.study-selection.search")
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
                @if(isset($editingStatus[$paper->id]))
                    <select wire:model="editingStatus.{{ $paper->id }}" wire:change="updateStatus({{ $paper->id }}, $event.target.value)">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                @else
                    <b wire:click="$set('editingStatus.{{ $paper->id }}', '{{ $paper->status }}')" data-search>
                        {{ $paper->status }}
                    </b>
                @endif
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

    @livewire('conducting.study-selection.paper-modal')
    <!-- Nova estrutura da tabela -->
    <table class="table table-striped">
    <thead>
        <tr>
            <th wire:click.prevent="sortBy('id_paper')" role="button">
                {{ __('project/conducting.study-selection.table.id') }}
                @if(isset($sorts['id_paper']))
                    @if($sorts['id_paper'] === 'asc')
                        ↑
                    @else
                        ↓
                    @endif
                @endif
            </th>
            <th wire:click.prevent="sortBy('title')" role="button">
                {{ __('project/conducting.study-selection.table.title') }}
                @if(isset($sorts['title']))
                    @if($sorts['title'] === 'asc')
                        ↑
                    @else
                        ↓
                    @endif
                @endif
            </th>
            <th wire:click.prevent="sortBy('criteria_acceptance')" role="button">
                {{ __('project/conducting.study-selection.table.acceptance-criteria') }}
                @if(isset($sorts['criteria_acceptance']))
                    @if($sorts['criteria_acceptance'] === 'asc')
                        ↑
                    @else
                        ↓
                    @endif
                @endif
            </th>
            <th wire:click.prevent="sortBy('criteria_rejection')" role="button">
                {{ __('project/conducting.study-selection.table.rejection-criteria') }}
                @if(isset($sorts['criteria_rejection']))
                    @if($sorts['criteria_rejection'] === 'asc')
                        ↑
                    @else
                        ↓
                    @endif
                @endif
            </th>
            <th wire:click.prevent="sortBy('data_base')" role="button">
                {{ __('project/conducting.study-selection.table.database') }}
                @if(isset($sorts['data_base']))
                    @if($sorts['data_base'] === 'asc')
                        ↑
                    @else
                        ↓
                    @endif
                @endif
            </th>
            <th wire:click.prevent="sortBy('status')" role="button">
                {{ __('project/conducting.study-selection.table.status') }}
                @if(isset($sorts['status']))
                    @if($sorts['status'] === 'asc')
                        ↑
                    @else
                        ↓
                    @endif
                @endif
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($papers as $paper)
        <tr>
            <td>{{ $paper['id_paper'] }}</td>
            <td><a href="#" wire:click.prevent="openPaper({{ $paper }})">{{ $paper['title'] }}</a></td>
            <td>{{ $paper['criteria_acceptance'] ?? '[wip]' }}</td>
            <td>{{ $paper['criteria_rejection'] ?? '[wip]' }}</td>
            <td>{{ $paper['data_base'] }}</td>
            <td>
                @if(isset($editingStatus[$paper['id_paper']]))
                    <select wire:model="editingStatus.{{ $paper['id_paper'] }}" wire:change="updateStatus({{ $paper['id_paper'] }}, $event.target.value)">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                @else
                    <b wire:click="$set('editingStatus.{{ $paper['id_paper'] }}', '{{ $paper['status'] }}')" data-search>
                        {{ $paper['status'] }}
                    </b>
                @endif
            </td>
            <td>
                <a class='btn btn-light' href="{{ $paper['url'] }}" wire:custom-directive>
                    <i class="fa fa-solid fa-share"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">
                <x-helpers.description>
                    {{ __("project/conducting.study-selection.papers.empty")}}
                </x-helpers.description>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>

@script
<script>
  Livewire.directive('custom-directive', {
    bind: function (el, binding, vnode) {
      el.addEventListener('click', function (event) {
        if (event.ctrlKey || event.metaKey) {
          event.preventDefault();
          window.open(binding.value);
        }
      });
    },
  });
</script>
@endscript

<!-- General Score Management -->
<div class="card">
       <hr>
        <x-search.input
            class="mt-3 w-md-50 w-100"
            target="search-questions"
            isTable
        /><br>

        <div class="card border">

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">{{ __("project/planning.quality-assessment.general-score.table.min") }}</th>
                        <th scope="col">{{ __("project/planning.quality-assessment.general-score.table.max") }}</th>
                        <th scope="col">{{ __("project/planning.quality-assessment.general-score.table.description") }}</th>
                        <th scope="col">{{ __("project/planning.quality-assessment.general-score.table.action") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($generalscore as $score)
                        <tr
                            class="px-4"
                            data-item="search-questions"
                            wire:key="{{ $score->id_general_score }}"
                        >
                            <td>{{ $score->start }}</td>
                            <td>{{ $score->end }}</td>
                            <td>
                                <span
                                    class="block text-wrap text-break"
                                    data-search
                                >
                                    {{ $score->description }}
                                </span>
                            </td>
                            <td>
                                <button
                                    class="btn py-1 px-3 btn-outline-secondary"
                                    wire:click="edit('{{ $score->id_general_score }}')"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    class="btn py-1 px-3 btn-outline-danger"
                                    wire:click="delete('{{ $score->id_general_score }}')"
                                    wire:target="delete('{{ $score->id_general_score }}')"
                                    wire:loading.attr="disabled"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <x-helpers.description>
                                    {{ __("project/planning.quality-assessment.general-score.table.empty") }}
                                </x-helpers.description>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <x-search.empty target="search-questions">
                                {{ __("project/planning.quality-assessment.general-score.table.no-results") }}
                            </x-search.empty>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@script
<script>
    $wire.on('general-score', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript

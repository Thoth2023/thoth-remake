<div class="card" style="border-radius: 20px 20px 0px 0px">
    <div class="mt-0 mx-0">
        <table class="table table-custom-hover m-0">
            <thead class="table-light">
                <tr class="p-0 m-0">
                    <th class="p-1 rounded-l-sm" style="width: 20px"></th>
                    <th scope="col" class="p-1">
                        {{ __("project/planning.data-extraction.table.header.id") }}
                    </th>
                    <th scope="col" class="p-1">
                        {{ __("project/planning.data-extraction.table.header.description") }}
                    </th>
                    <th scope="col" class="p-1">Peso</th>
                    <th scope="col" class="p-1">Mínimo para Aprovar</th>
                    <th scope="col" class="p-1 rounded-r-sm">
                        {{ __("project/planning.data-extraction.table.header.actions") }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>
                            @if ($question->qualityScores->isNotEmpty())
                                <x-table.accordion-button />
                            @endif
                        </td>
                        <td>{{ $question->id_qa }}</td>
                        <td class="text-wrap">
                            {{ $question->description }}
                        </td>
                        <td>
                            {{ $question->weight }}
                        </td>
                        <td class="max-width: 50px;">
                            <x-select>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </x-select>
                        </td>
                        <td>
                            <div style="min-width: fit-content">
                                <button
                                    type="button"
                                    {{-- wire:click="sendEditDataToAnotherComponent({{ $question }})" --}}
                                    class="btn btn-outline-secondary py-1 px-3 m-0"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    class="btn btn-outline-danger py-1 px-3 m-0"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @if ($question->qualityScores->isNotEmpty())
                        <x-table.accordion-content>
                            <td colspan="6">
                                <table class="table" style="margin: 0 2rem">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="p-1">
                                                Score Rule
                                            </th>
                                            <th scope="col" class="p-1">
                                                Description
                                            </th>
                                            <th scope="col" class="p-1">
                                                Score
                                            </th>
                                            <th scope="col" class="p-1">
                                                Weight
                                            </th>
                                            <th
                                                scope="col"
                                                class="p-1 rounded-r-sm"
                                            >
                                                {{ __("project/planning.data-extraction.table.header.actions") }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($question->qualityScores as $question)
                                            <tr>
                                                <td>
                                                    {{ $question->scoreRule }}
                                                    {{ $question }}
                                                </td>
                                                <td class="text-wrap">
                                                    {{ $question->description }}
                                                </td>
                                                <td>
                                                    {{ $question->score }}%
                                                </td>
                                                <td>
                                                    {{ $question->weight }}
                                                </td>
                                                <td>
                                                    <div
                                                        style="
                                                            min-width: fit-content;
                                                        "
                                                    >
                                                        <button
                                                            type="button"
                                                            {{-- wire:click="sendEditDataToAnotherComponent({{ $question }})" --}}
                                                            class="btn btn-outline-secondary py-1 px-3 m-0"
                                                        >
                                                            <i
                                                                class="fas fa-edit"
                                                            ></i>
                                                        </button>
                                                        <button
                                                            class="btn btn-outline-danger py-1 px-3 m-0"
                                                        >
                                                            <i
                                                                class="fas fa-trash"
                                                            ></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </x-table.accordion-content>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

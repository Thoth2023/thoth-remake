<style>
    .protocol-box {
        background: #f9fafb;
        border: 1px solid #e3e6ea;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.9rem;
    }

    .protocol-table {
        font-size: .85rem; /* menor fonte */
        border: 1px solid #e3e6ea;
        border-radius: 8px;
        overflow: hidden;
    }

    .protocol-table thead {
        background: #f9fafb;
        font-weight: bold;
        color: #344767;
        border-bottom: 1px solid #e3e6ea;
    }

    .protocol-table td,
    .protocol-table th {
        padding: 8px 10px;
        vertical-align: top;
        word-break: break-word;
        white-space: normal;
    }

    .protocol-table tbody tr:nth-child(odd) {
        background: #ffffff;
    }

    .protocol-table tbody tr:nth-child(even) {
        background: #f3f6fa;
    }

    .desc-col {
        width: 40%;
    }
</style>


<div class="row g-3 mt-2">
    <div class="col-12">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.data_extraction_questions') }}</strong>

            <div class="protocol-table mt-2">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="desc-col">{{ __('project/public_protocol.description') }}</th>
                        <th>{{ __('project/public_protocol.question_type') }}</th>
                        <th>{{ __('project/public_protocol.options') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse(($questions ?? []) as $q)
                        <tr>
                            <td>{{ $q->id }}</td>
                            <td class="text-break">{{ $q->description }}</td>
                            <td>{{ $q->question_type->type ?? '—' }}</td>
                            <td class="text-break">
                                @if($q->options->isNotEmpty())
                                    @foreach($q->options as $option)
                                        <div>• {{ $option->description }}</div>
                                    @endforeach
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">— {{ __('project/public_protocol.no_data_extraction_questions') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

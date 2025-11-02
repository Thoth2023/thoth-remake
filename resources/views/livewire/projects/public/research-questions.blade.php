<style>
    .protocol-table {
        font-size: .9rem;
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
        padding: 10px;
        vertical-align: top;
        word-break: break-word;
        white-space: normal; /* garante quebra */
    }

    .protocol-table tbody tr:nth-child(odd) {
        background: #ffffff;
    }

    .protocol-table tbody tr:nth-child(even) {
        background: #f3f6fa;
    }
</style>

<div class="mt-4">

    @if($questions->count() > 0)
         <div class="table-responsive protocol-table">
            <table class="table mb-0">
                <thead class="bg-light">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>{{ __('project/public_protocol.description') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td class="text-break">{{ $question->description }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    @else
        <p class="text-muted">{{ __('project/public_protocol.no_questions') }}</p>
    @endif

</div>

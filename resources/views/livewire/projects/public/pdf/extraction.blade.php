{{-- EXTRAÇÃO DE DADOS --}}
<h6 class="mb-2 text-uppercase" id="toc-extraction">{{ __('project/public_protocol.data_extraction') }}</h6>
<div class="protocol-box">
    <table class="table">
        <thead>
        <tr>
            <th style="width:60px">ID</th>
            <th>{{ __('project/public_protocol.description') }}</th>
            <th style="width:35%">{{ __('project/public_protocol.options') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($extractionQuestions as $q)
            <tr>
                <td>{{ $q->id }}</td>
                <td class="text-break">{{ $q->description }}</td>
                <td class="text-break">
                    @if(($q->options ?? collect())->isNotEmpty())
                        @foreach($q->options as $o)
                            <div>• {{ $o->description }}</div>
                        @endforeach
                    @else — @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="3">—</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

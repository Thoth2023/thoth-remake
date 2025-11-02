<style>
    .criteria-wrap {
        white-space: normal !important;
        word-break: break-word !important;
        max-width: 100%;
    }
</style>

<div class="mt-4">

    @if($inclusion->isEmpty() && $exclusion->isEmpty())
        <p class="text-muted small">{{ __('project/public_protocol.no_criteria') }}</p>
    @else
        <div class="table-responsive">

            <table class="table table-striped align-items-center mb-0">
                <thead class="bg-light">
                <tr>
                    <th class="text-muted small">#</th>
                    <th class="text-muted small">{{ __('project/public_protocol.description') }}</th>
                    <th class="text-muted small text-center">{{ __('project/public_protocol.type') }}</th>
                    <th class="text-muted small text-center">{{ __('project/public_protocol.rule') }}</th>
                </tr>
                </thead>

                <tbody>

                {{-- INCLUSION CRITERIA FIRST --}}
                @foreach($inclusion as $c)
                    <tr>
                        <td class="fw-bold text-nowrap">{{ $c->id }}</td>
                        <td class="criteria-wrap text-break">{{ $c->description }}</td>
                        <td class="text-success fw-bold text-center">
                            {{ __('project/public_protocol.inclusion') }}
                        </td>
                        <td class="text-center text-primary">
                            {{ strtoupper($c->rule ?? 'ALL') }}
                        </td>
                    </tr>
                @endforeach

                {{-- EXCLUSION --}}
                @foreach($exclusion as $c)
                    <tr>
                        <td class="fw-bold text-nowrap">{{ $c->id }}</td>
                        <td class="criteria-wrap text-break">{{ $c->description }}</td>
                        <td class="text-danger fw-bold text-center">
                            {{ __('project/public_protocol.exclusion') }}
                        </td>
                        <td class="text-center text-primary">
                            {{ strtoupper($c->rule ?? 'ANY') }}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    @endif
</div>

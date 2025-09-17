<div>
    @if($questions->count() > 0)
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th>{{ __('project/public_protocol.id') }}</th>
                        <th>{{ __('project/public_protocol.description') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>{{ $question->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">{{ __('project/public_protocol.no_questions') }}</p>
    @endif
</div>

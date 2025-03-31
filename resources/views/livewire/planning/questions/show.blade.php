<div>
    @if($questions->count() > 0)
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th>{{ __('research_questions.id') }}</th>
                        <th>{{ __('research_questions.description') }}</th>
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
        <p class="text-muted">{{ __('research_questions.no_questions') }}</p>
    @endif
</div>

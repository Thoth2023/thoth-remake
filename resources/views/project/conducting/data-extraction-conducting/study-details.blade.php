<div id="studyDetails" class="d-none mt-5">
    <h4>{{ __('project/conducting.questions_table.title') }}</h4>
    <form id="extractionForm">
        @if(count($dataExtractionQuestions) > 0)
            @foreach($dataExtractionQuestions as $question)
                <div class="form-group">
                    <label for="question{{ $question->id }}">{{ $question->description }}</label>
                    <textarea id="question{{ $question->id }}" class="form-control" required></textarea>
                </div>
            @endforeach
        @endif
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
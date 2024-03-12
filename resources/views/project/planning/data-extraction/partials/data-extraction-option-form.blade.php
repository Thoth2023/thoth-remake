<!-- data-extraction-option-form.blade.php -->

<div class="card-body col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('project/planning.data-extraction.option-form.title') }}</h5>
                @include ('components.help-button', ['dataTarget' => 'DataExtractionOptionModal'])
                <!-- Help Button Description -->
                @include('components.help-modal', [
                    'modalId' => 'DataExtractionOptionModal',
                    'modalLabel' => 'DataExtractionOptionLabel',
                    'modalTitle' => __('project/planning.data-extraction.option-form.help.title'),
                    'modalContent' => __('project/planning.data-extraction.option-form.help.content'),
                ])
            </div>
        </div>
        <div class="card-body">
            <form role="form" method="POST"
                action="{{ route('project.planning.data-extraction.option.store', ['projectId' => $project->id_project]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="question-id"
                        class="form-control-label">{{ __('project/planning.data-extraction.option-form.question') }}</label>
                    <select class="form-control" name="questionId" id="question-id">
                        @foreach ($project->questions as $question)
                            @if ($question->question_type->type === 'Multiple Choice List' || $question->question_type->type === 'Pick One List')
                                <option value="{{ $question->id_de }}">{{ $question->id }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="option"
                        class="form-control-label">{{ __('project/planning.data-extraction.option-form.option') }}</label>
                    <input class="form-control" id="option" type="text" name="option">
                </div>

                <button type="submit"
                    class="btn btn-success mt-3">{{ __('project/planning.data-extraction.option-form.add-option') }}</button>
            </form>
        </div>
    </div>
</div>

<!-- data-extraction-question-form.blade.php -->

<div class="card-body col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('project/planning.data-extraction.question-form.title') }}</h5>
                @include ('components.help-button', ['dataTarget' => 'DataExtractionQuestionModal'])
                <!-- Help Button Description -->
                @include('components.help-modal', [
                    'modalId' => 'DataExtractionQuestionModal',
                    'modalLabel' => 'DataExtractionQuestionLabel',
                    'modalTitle' => __('project/planning.data-extraction.question-form.help.title'),
                    'modalContent' => __('project/planning.data-extraction.question-form.help.content'),
                ])
            </div>
        </div>
        <div class="card-body">
            <form role="form" method="POST"
                action="{{ route('project.planning.data-extraction.question.store', ['projectId' => $project->id_project]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id" class="form-control-label">{{ __('project/planning.data-extraction.question-form.id') }}</label>
                    <input type="text" class="form-control" id="id" name="id" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-control-label">{{ __('project/planning.data-extraction.question-form.description') }}</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>

                <div class="form-group">
                    <label for="type" class="form-control-label">{{ __('project/planning.data-extraction.question-form.type') }}</label>
                    <select class="form-control" name="type" id="type" required>
                        @foreach ($questionTypes as $type)
                            <option value="{{ $type->id_type }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-3">{{ __('project/planning.data-extraction.question-form.add-question') }}</button>
            </form>
        </div>
    </div>
</div>


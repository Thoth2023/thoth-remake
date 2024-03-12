<!-- data-extraction-question.blade.php -->


<li class="list-group-item">
    <div class="row">
        <div class="col-1">
            <span>{{ $question->id }}</span>
        </div>
        <div class="col">
            <span>{{ $question->description }}</span>
        </div>
        <div class="col">
            <span>{{ $question->question_type->type }}</span>
        </div>
        <div class="col-5">
            <ul class="list-group">
                @foreach ($question->options as $option)
                    @include('project.planning.data-extraction.partials.data-extraction-option', [
                        'option' => $option,
                        'project' => $project,
                    ])
                @endforeach
            </ul>
        </div>
        <div class="col-md-auto d-flex">
            @include('project.planning.data-extraction.partials.edit-question-modal', [
                'question' => $question,
                'types' => $types,
                'project' => $project,
            ])
            <form class="m-1" role="form" method="POST"
                action="{{ route('project.planning.data-extraction.question.destroy', ['projectId' => $project->id_project, 'question' => $question]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding: 7px;"
                        class="btn btn-outline-danger btn-group-sm btn-sm">Delete</button>
            </form>
        </div>
    </div>
</li>

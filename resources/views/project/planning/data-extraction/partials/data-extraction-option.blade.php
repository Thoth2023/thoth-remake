<!-- data-extraction-option.blade.php -->

<li class="list-group-item">
    <div class="row">
        <div class="col">
            <span>{{ $option->description }}</span>
        </div>
        <div class="col-md-auto d-flex">
            @include('project.planning.data-extraction.partials.edit-option-modal', [
                'option' => $option,
                'project' => $project,
            ])
            <form class="m-1" role="form" method="POST"
                action="{{ route('project.planning.data-extraction.option.destroy', [$project->id_project, $option->id_option]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>
</li>

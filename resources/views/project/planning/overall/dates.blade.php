<div class="card-body col-md-6 pt-3">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0">
                {{ __('project/planning.overall.dates.title') }}
                </p>
                @include ('components.help-button', ['dataTarget' => 'DatesModal'])
                <!-- Help Button Description -->
                @include(
                'components.help-modal',
                [
                    'modalId' => 'DatesModal',
                    'modalLabel' => 'exampleModalLabel',
                    'modalTitle' => __('project/planning.overall.dates.help.title'),
                    'modalContent' => __('project/planning.overall.dates.help.content')
                    ]
                )
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('project.planning_overall.add-date', $id_project) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="start_date">
                        {{ __('project/planning.overall.dates.start_date') }}:
                    </label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $project->start_date ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label for="end_date">
                        {{ __('project/planning.overall.dates.end_date') }}:
                    </label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $project->end_date ?? '' }}" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-success mt-1">
                        {{ __('project/planning.overall.dates.add_date') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


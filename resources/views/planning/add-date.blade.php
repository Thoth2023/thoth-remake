<form action="{{ route('planning_overall.add-date', $id_project) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $project->start_date ?? '' }}" required>
    </div>
    <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $project->end_date ?? '' }}" required>
    </div>
    <div>
        <button type="submit" class="btn btn-primary">Add Date</button>
    </div>
</form>


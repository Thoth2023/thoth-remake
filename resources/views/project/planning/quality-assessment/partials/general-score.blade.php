<!-- General Score Management -->
<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-header">
            General Score Management
        </div>
        <div class="card-body">
            <form method="post"
                action="{{ route('project.planning.quality-assessment.general-score.store', ['projectId' => $id_project]) }}">
                @csrf

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Min</span>
                        <input name="start" min="0.0" step="1" max="100" type="number"
                            class="form-control" placeholder="minScore" aria-label="minScore"
                            aria-describedby="basic-addon1">
                        <span class="input-group-text" id="maxScore">Max</span>
                        <input name="end" min="0.0" step="1" max="100" type="number"
                            class="form-control" placeholder="maxScore" aria-label="maxScore"
                            aria-describedby="maxScore">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <input name="description" type="text" class="form-control" id="description"
                        placeholder="Enter description">
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>

            <form>
                <div class="form-group">
                    <label for="minGeneralScore">Minimum General Score for Approval:</label>
                    <select class="form-control" id="minGeneralScore">
                        @forelse($project->generalScores as $generalScore)
                            <option value="{{ $generalScore->id_general_score }}">{{ $generalScore->description }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </form>

            <hr>


            <div class="card border">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Min</th>
                                <th scope="col">Max</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($project->generalScores as $generalScore)
                                <tr>
                                    <td>{{ $generalScore->start }}</td>
                                    <td>{{ $generalScore->end }}</td>
                                    <td>{{ $generalScore->description }}</td>
                                    <td>
                                        <span class="d-flex">
                                            @include('project.planning.quality-assessment.partials.general-score-edit-modal')
                                            <form
                                                action="{{ route('project.planning.quality-assessment.general-score.destroy', ['general_score' => $generalScore, 'projectId' => $project->id_project]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to remove this general score?')"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Delete category"
                                                    class="border-0 bg-transparent">
                                                    <i class="fas fa-trash text-secondary" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No general score found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

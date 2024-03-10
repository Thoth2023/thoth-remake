<hr>
<h6>Exclusion Criterias</h6>
<div class="table-responsive p-0" id="exclusion_criteria">
    <table class="table align-items-center justify-content-center mb-0">
        <thead>
            <tr>
                <th>Select</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($project->exclusionCriterias as $criterion)
                <tr>
                    <td>
                        @if ($criterion->pre_selected == 0)
                            <form
                                action="{{ route('project.planning.criteria.change-preselected', ['projectId' => $project->id_project, 'criteriaId' => $criterion->id_criteria]) }}#exclusion_criteria"
                                id="pre_select_form-<?= $criterion->id_criteria ?>" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="checkbox" name="pre_selected" value="1"
                                    id="check-box-<?= $criterion->id_criteria ?>" onChange="this.form.submit()">
                            </form>
                        @else
                            <form
                                action="{{ route('project.planning.criteria.change-preselected', ['projectId' => $project->id_project, 'criteriaId' => $criterion->id_criteria]) }}#exclusion_criteria"
                                id="pre_select_form-<?= $criterion->id_criteria ?>" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="checkbox" id="check-box-<?= $criterion->id_criteria ?>"
                                    onChange="this.form.submit()" checked>
                                <input type="hidden" name="pre_selected" value="0">
                            </form>
                        @endif
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $criterion->id }}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $criterion->description }}</p>
                    </td>
                    <td class="align-middle">
                        <button style="border:0; background: none; padding: 0px;" type="button"
                            class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal"
                            data-bs-target="#modal-form{{ $criterion->id_criteria }}"
                            data-original-title="Edit criteria">Edit</button>
                        <!-- Modal Here Edition -->
                        @include('project.planning.criteria.partials.edit-modal')
                        <!-- Modal Ends Here -->
                    </td>
                    <td class="align-middle">
                        <form
                            action="{{ route('project.planning.criteria.destroy', ['projectId' => $project->id_project, 'criterion' => $criterion]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button style="border:0; background: none; padding: 0px;" type="submit"
                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                data-original-title="Delete Criteria">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No criteria found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="col-md-2">
        <br>
        <label class="form-control-label">Exclusion Rule</label>
        <select class="form-control" name="exclusion_rule">
            <option value="all">All</option>
            <option value="any">Any</option>
            <option value="at_least">At Least</option>
        </select>
        <br>
    </div>
</div>

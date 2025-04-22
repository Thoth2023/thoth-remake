<div class="card-group col-lg-6">
    <div class="card">
        <div class="card-header">
<h6>{{ translationPlanning('criteria.exclusion-table.title') }}</h6>
        </div>
        <div class="card-body">
<div class="table-responsive p-0" id="exclusion_criteria">
    <table class="table align-items-center justify-content-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ translationPlanning('criteria.exclusion-table.select') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    {{ translationPlanning('criteria.exclusion-table.id') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    {{ translationPlanning('criteria.exclusion-table.description') }}</th>
                <th colspan="2"></th>
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
                    <td style="max-width: 185px">
                        <p class="text-wrap text-sm font-weight-bold mb-0">{{ $criterion->description }}</p>
                    </td>
                    <td class="col-md-auto d-flex">
                        <button style="padding: 7px;" type="button"
                                class="btn btn-outline-secondary btn-group-sm btn-sm m-1"  data-bs-toggle="modal"
                            data-bs-target="#modal-form{{ $criterion->id_criteria }}"
                            data-original-title="{{ translationPlanning('criteria.exclusion-table.edit') }}">{{ translationPlanning('criteria.exclusion-table.edit') }}</button>
                        <!-- Modal Here Edition -->
                        @include('project.planning.criteria.partials.edit-modal')
                        <!-- Modal Ends Here -->

                        <form
                            action="{{ route('project.planning.criteria.destroy', ['projectId' => $project->id_project, 'criterion' => $criterion]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button style="padding: 7px;" type="submit"
                                    class="btn btn-outline-danger btn-group-sm btn-sm m-1"  data-toggle="tooltip"
                                data-original-title="{{ translationPlanning('criteria.exclusion-table.delete') }}">{{ translationPlanning('criteria.exclusion-table.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        {{ translationPlanning('criteria.exclusion-table.no-criteria') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="col-md-2">
        <br>
        <label class="form-control-label">{{ translationPlanning('criteria.exclusion-table.rule') }}</label>
        <select class="form-control" name="exclusion_rule">
            <option value="all">{{ translationPlanning('criteria.exclusion-table.all') }}</option>
            <option value="any">{{ translationPlanning('criteria.exclusion-table.any') }}</option>
            <option value="at_least">{{ translationPlanning('criteria.exclusion-table.at-least') }}</option>
        </select>
        <br>
    </div>

</div>
    </div>
</div>
</div>

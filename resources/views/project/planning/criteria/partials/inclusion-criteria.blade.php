<div class="card-group col-lg-6">
    <div class="card">
    <div class="card-header">
    <h6>{{ translationPlanning('criteria.inclusion-table.title') }}</h6>
    </div>
        <div class="card-body">
<div class="table-responsive p-0" id="inclusion_criteria">
    <table class="table align-items-center justify-content-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ translationPlanning('criteria.inclusion-table.select') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    {{ translationPlanning('criteria.inclusion-table.id') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    {{ translationPlanning('criteria.inclusion-table.description') }}</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($project->inclusionCriterias as $criterion)
                <tr>
                    <td>
                        @if ($criterion->pre_selected == 0)
                            <form
                                action="{{ route('project.planning.criteria.change-preselected', ['projectId' => $project->id_project, 'criteriaId' => $criterion->id_criteria]) }}#inclusion_criteria"
                                id="pre_select_form-<?= $criterion->id_criteria ?>" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="checkbox" name="pre_selected" value="1"
                                    id="check-box-<?= $criterion->id_criteria ?>" onChange="this.form.submit()">
                            </form>
                        @else
                            <form
                                action="{{ route('project.planning.criteria.change-preselected', ['projectId' => $project->id_project, 'criteriaId' => $criterion->id_criteria]) }}#inclusion_criteria"
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
                    <td class="col-md-auto d-flex ">
                        <button  type="button" style="padding: 7px;"
                                 class="btn btn-outline-secondary btn-group-sm btn-sm m-1" data-bs-toggle="modal"
                            data-bs-target="#modal-form{{ $criterion->id_criteria }}"
                            data-original-title="{{ translationPlanning('criteria.inclusion-table.edit') }}">{{ translationPlanning('criteria.inclusion-table.edit') }}</button>
                        <!-- Modal Here Edition -->
                        @include('project.planning.criteria.partials.edit-modal')
                        <!-- Modal Ends Here -->

                        <form
                            action="{{ route('project.planning.criteria.destroy', ['projectId' => $project->id_project, 'criterion' => $criterion]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button  type="submit" style="padding: 7px;"
                                     class="btn btn-outline-danger btn-group-sm btn-sm m-1" data-toggle="tooltip"
                                data-original-title="{{ translationPlanning('criteria.inclusion-table.delete') }}">{{ translationPlanning('criteria.inclusion-table.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        {{ translationPlanning('criteria.inclusion-table.no-criteria') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="col-md-2">
        <br>
        <label class="form-control-label">{{ translationPlanning('criteria.inclusion-table.rule') }}</label>
        <select class="form-control" name="inclusion_rule">
            <option value="all">{{ translationPlanning('criteria.inclusion-table.all') }}</option>
            <option value="any">{{ translationPlanning('criteria.inclusion-table.any') }}</option>
            <option value="at_least">{{ translationPlanning('criteria.inclusion-table.at-least') }}</option>
        </select>
        <br>
     </div>
</div>
    </div>
</div>
</div>

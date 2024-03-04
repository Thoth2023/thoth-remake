<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-5">
        <div class="card">
            <form role="form" method="POST"
                action="{{ route('project.planning_criteria.Add') }}"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Criteria</p>
                            <button type="button" class="help-thoth-button"
                                data-bs-toggle="modal"
                                data-bs-target="#Criteria">
                                ?
                            </button>
                            <!-- Help Button Description -->
                            <div class="modal fade" id="Criteria" tabindex="-1"
                                role="dialog"
                                aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="exampleModalLabel">Help for
                                                Criteria</h5>
                                            <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                class="btn bg-gradient-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Help Description Ends Here -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input"
                                        class="form-control-label">ID</label>
                                    <input class="form-control" type="text"
                                        name="id" required>
                                    <label for="example-text-input"
                                        class="form-control-label">Description</label>
                                    <input class="form-control" type="text"
                                        name="description" required>
                                    <label for="example-text-input"
                                        class="form-control-label">Type</label>
                                    <select class="form-control" name="type">
                                        <option value="Inclusion">Inclusion</option>
                                        <option value="Exclusion">Exclusion</option>
                                    </select>
                                    <input class="form-control" type="hidden"
                                        name="id_project"
                                        value="{{ $id_project }}">
                                    <input class="form-control" type="hidden"
                                        name="pre_selected" value="0">
                                </div>
                                <button type="submit"
                                class="btn btn-success mt-3">Add</button>
                            </div>
            </form>
                        <hr>
                        <h6>Inclusion Criterias</h6>
                        <div class="table-responsive p-0"
                            id="inclusion_criteria">
                            <table
                                class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Description
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($project->inclusion_criterias as $criteria)
                                    <tr>
                                        <td>
                                            @if($criteria->pre_selected == 0)
                                            <form
                                                action="{{ route('planning_criteria.ChangeSelect', $criteria->id_criteria) }}#inclusion_criteria"
                                                id="pre_select_form-<?=$criteria->id_criteria;?>"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="checkbox"
                                                    name="pre_selected"
                                                    value="1"
                                                    id="check-box-<?=$criteria->id_criteria;?>"
                                                    onChange="this.form.submit()">
                                            </form>
                                            @else
                                            <form
                                                action="{{ route('planning_criteria.ChangeSelect', $criteria->id_criteria) }}#inclusion_criteria"
                                                id="pre_select_form-<?=$criteria->id_criteria;?>"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="checkbox"
                                                    id="check-box-<?=$criteria->id_criteria;?>"
                                                    onChange="this.form.submit()"
                                                    checked>
                                                <input type="hidden"
                                                    name="pre_selected"
                                                    value="0">
                                            </form>
                                            @endif
                                        </td>
                                        <td>
                                            <p
                                                class="text-sm font-weight-bold mb-0">{{
                                                $criteria->id }}</p>
                                        </td>
                                        <td>
                                            <p
                                                class="text-sm font-weight-bold mb-0">{{
                                                $criteria->description }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <button
                                                style="border:0; background: none; padding: 0px;"
                                                type="button"
                                                class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-form{{ $criteria->id_criteria }}"
                                                data-original-title="Edit criteria">Edit</button>
                                            <!-- Modal Here Edition -->
                                            <div class="col-md-4">
                                                <div class="modal fade"
                                                    id="modal-form{{ $criteria->id_criteria }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="modal-form"
                                                    aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-md"
                                                        role="document">
                                                        <div
                                                            class="modal-content">
                                                            <div
                                                                class="modal-body p-0">
                                                                <div
                                                                    class="card card-plain">
                                                                    <div
                                                                        class="card-header pb-0 text-left">
                                                                        <h3>Criteria
                                                                            Update</h3>
                                                                    </div>
                                                                    <div
                                                                        class="card-body">
                                                                        <form
                                                                            role="form text-left"
                                                                            method="POST"
                                                                            action="{{ route('planning_criteria.Edit', $criteria->id_criteria) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <label
                                                                                for="example-text-input"
                                                                                class="form-control-label">ID</label>
                                                                            <input
                                                                                class="form-control"
                                                                                type="text"
                                                                                name="id"
                                                                                value="{{ $criteria->id }}"
                                                                                required>
                                                                            <label
                                                                                for="example-text-input"
                                                                                class="form-control-label">Description</label>
                                                                            <input
                                                                                class="form-control"
                                                                                type="text"
                                                                                name="description"
                                                                                value="{{ $criteria->description }}"
                                                                                required>
                                                                            <label
                                                                                for="example-text-input"
                                                                                class="form-control-label">Type</label>
                                                                            <select
                                                                                class="form-control"
                                                                                name="type">
                                                                                <option
                                                                                    value="{{ $criteria->type }}"><?=
                                                                                    $criteria->type
                                                                                    ?></option>
                                                                                <option
                                                                                    value="Exclusion">Exclusion</option>
                                                                            </select>
                                                                            <input
                                                                                class="form-control"
                                                                                type="hidden"
                                                                                name="id_project"
                                                                                value="{{ $id_project }}">
                                                                            <input
                                                                                class="form-control"
                                                                                type="hidden"
                                                                                name="pre_selected"
                                                                                value="{{ $criteria->pre_selected }}">
                                                                            <div
                                                                                class="text-center">
                                                                                <button
                                                                                    type="submit"
                                                                                    class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Ends Here -->
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('planning_criteria.Destroy', $criteria->id_criteria) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        style="border:0; background: none; padding: 0px;"
                                                        type="submit"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip"
                                                        data-original-title="Delete Criteria">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No
                                                criteria found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                            </table>
                                <div class="col-md-2">
                                    <br>
                                    <label class="form-control-label">Inclusion
                                        Rule</label>
                                    <select class="form-control"
                                        name="inclusion_rule">
                                        <option value="all">All</option>
                                        <option value="any">Any</option>
                                        <option value="at_least">At Least</option>
                                    </select>
                                    <br>
                                </div>
                                <hr>
                                <h6>Exclusion Criterias</h6>
                                <div class="table-responsive p-0"
                                    id="exclusion_criteria">
                                    <table
                                        class="table align-items-center justify-content-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    ID
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Description
                                                </th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($project->exclusion_criterias as $criteria)
                                            <tr>
                                                <td>
                                                    @if($criteria->pre_selected == 0)
                                                    <form
                                                        action="{{ route('planning_criteria.ChangeSelect', $criteria->id_criteria) }}#exclusion_criteria"
                                                        id="pre_select_form-<?=$criteria->id_criteria;?>"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="checkbox"
                                                            name="pre_selected"
                                                            value="1"
                                                            id="check-box-<?=$criteria->id_criteria;?>"
                                                            onChange="this.form.submit()">
                                                    </form>
                                                    @else
                                                    <form
                                                        action="{{ route('planning_criteria.ChangeSelect', $criteria->id_criteria) }}#exclusion_criteria"
                                                        id="pre_select_form-<?=$criteria->id_criteria;?>"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="checkbox"
                                                            id="check-box-<?=$criteria->id_criteria;?>"
                                                            onChange="this.form.submit()"
                                                            checked>
                                                        <input type="hidden"
                                                            name="pre_selected"
                                                            value="0">
                                                    </form>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p
                                                        class="text-sm font-weight-bold mb-0">{{
                                                        $criteria->id }}</p>
                                                </td>
                                                <td>
                                                    <p
                                                        class="text-sm font-weight-bold mb-0">{{
                                                        $criteria->description
                                                        }}</p>
                                                </td>
                                                <td class="align-middle">
                                                    <button
                                                        style="border:0; background: none; padding: 0px;"
                                                        type="button"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-form{{ $criteria->id_criteria }}"
                                                        data-original-title="Edit criteria">Edit</button>
                                                    <!-- Modal Here Edition -->
                                                    <div class="col-md-4">
                                                        <div class="modal fade"
                                                            id="modal-form{{ $criteria->id_criteria }}"
                                                            tabindex="-1"
                                                            role="dialog"
                                                            aria-labelledby="modal-form"
                                                            aria-hidden="true">
                                                            <div
                                                                class="modal-dialog modal-dialog-centered modal-md"
                                                                role="document">
                                                                <div
                                                                    class="modal-content">
                                                                    <div
                                                                        class="modal-body p-0">
                                                                        <div
                                                                            class="card card-plain">
                                                                            <div
                                                                                class="card-header pb-0 text-left">
                                                                                <h3>Criteria
                                                                                    Update</h3>
                                                                            </div>
                                                                            <div
                                                                                class="card-body">
                                                                                <form
                                                                                    role="form text-left"
                                                                                    method="POST"
                                                                                    action="{{ route('planning_criteria.Edit', $criteria->id_criteria) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <label
                                                                                        for="example-text-input"
                                                                                        class="form-control-label">ID</label>
                                                                                    <input
                                                                                        class="form-control"
                                                                                        type="text"
                                                                                        name="id"
                                                                                        value="{{ $criteria->id }}"
                                                                                        required>
                                                                                    <label
                                                                                        for="example-text-input"
                                                                                        class="form-control-label">Description</label>
                                                                                    <input
                                                                                        class="form-control"
                                                                                        type="text"
                                                                                        name="description"
                                                                                        value="{{ $criteria->description }}"
                                                                                        required>
                                                                                    <label
                                                                                        for="example-text-input"
                                                                                        class="form-control-label">Type</label>
                                                                                    <select
                                                                                        class="form-control"
                                                                                        name="type">
                                                                                        <option
                                                                                            value="{{ $criteria->type }}"><?=
                                                                                            $criteria->type
                                                                                            ?></option>
                                                                                        <option
                                                                                            value="Inclusion">Inclusion</option>
                                                                                    </select>
                                                                                    <input
                                                                                        class="form-control"
                                                                                        type="hidden"
                                                                                        name="id_project"
                                                                                        value="{{ $id_project }}">
                                                                                    <input
                                                                                        class="form-control"
                                                                                        type="hidden"
                                                                                        name="pre_selected"
                                                                                        value="{{ $criteria->pre_selected }}">
                                                                                    <div
                                                                                        class="text-center">
                                                                                        <button
                                                                                            type="submit"
                                                                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Ends Here -->
                                                    </td>
                                                    <td class="align-middle">
                                                        <form
                                                            action="{{ route('planning_criteria.Destroy', $criteria->id_criteria) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                style="border:0; background: none; padding: 0px;"
                                                                type="submit"
                                                                class="text-secondary font-weight-bold text-xs"
                                                                data-toggle="tooltip"
                                                                data-original-title="Delete Criteria">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5"
                                                        class="text-center">No
                                                        criteria found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <div class="col-md-2">
                                            <br>
                                            <label class="form-control-label">Exclusion
                                                Rule</label>
                                            <select class="form-control"
                                                name="exclusion_rule">
                                                <option value="all">All</option>
                                                <option value="any">Any</option>
                                                <option value="at_least">At
                                                    Least</option>
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

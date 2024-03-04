<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-5">
                <div class="card">
                    <form role="form" method="POST" action={{
                        route('project.planning_overall.databaseAdd') }}
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Databases</p>
                                    <button type="button" class="help-thoth-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#DatabaseModal">
                                        ?
                                    </button>
                                    <!-- Help Button Description -->
                                    <div class="modal fade" id="DatabaseModal" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">Help for Data
                                                        Bases</h5>
                                                    <button type="button" class="btn-close"
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
                                            <select class="form-control" name="id_database">
                                                @forelse ($databases as $database)
                                                <option value="{{ $database->id_database }}">{{
                                                    $database->name }}</option>
                                                @empty
                                                <option>No data bases in database.</option>
                                                @endforelse
                                            </select>
                                            <input clas="form-control" type="hidden"
                                                name="id_project" value="{{ $id_project }}">

                                        </div>
                                        <button type="submit" class="btn btn-success mt-3">Add
                                            Database</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table
                                class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Data Bases
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($projectDatabases as $projectDatabase)
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0"><?=convert_databases_name($projectDatabase->id_database)?></p>
                                        </td>
                                        <td class="align-middle">
                                            <form
                                                action="{{ route('planning_overall.databaseDestroy', $projectDatabase->id_database) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @error('name')
                                    <p>{{ $message }}</p>
                                    @enderror
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No
                                            databases found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="container-fluid py-4">
                            <p class="mb-0">Suggest a new Data Base:</p>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input"
                                        class="form-control-label">Data Base name:</label>
                                    <input class="form-control" type="text"
                                        name="description">
                                    <input clas="form-control" type="hidden"
                                        name="id_project" value="{{ $id_project }}">

                                    <label for="example-text-input"
                                        class="form-control-label">Data Base Link:</label>
                                    <input class="form-control" type="text"
                                        name="description">
                                    <input clas="form-control" type="hidden"
                                        name="id_project" value="{{ $id_project }}">

                                </div>
                                <button type="submit"
                                    class="btn btn-primary btn-sm ms-auto">Send
                                    suggestion</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

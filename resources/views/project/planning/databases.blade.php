<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-1">
                <div class="card">
                    <div>
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0">{{ __('Databases') }}</p>
                                @include ('components.help-button', ['dataTarget' => 'DatabasesModal'])
                                <!-- Help Button Description -->
                                @include('components.help-modal', [
                                    'modalId' => 'DatabasesModal',
                                    'modalLabel' => 'exampleModalLabel',
                                    'modalTitle' => __('project/planning.overall.domain.help.title'),
                                    'modalContent' => __('project/planning.overall.domain.help.content'),
                                ])
                            </div>
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST"
                                action="{{ route('projects.planning.databases.add', ['projectId' => $project->id_project]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control" name="databaseId">
                                                @forelse ($databases as $database)
                                                    <option value="{{ $database->id_database }}">{{ $database->name }}
                                                    </option>
                                                @empty
                                                    <option>No data bases in database.</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success mt-3">Add Database</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Data Bases
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($project->databases as $projectDatabase)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $projectDatabase->name }}
                                                </p>
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('projects.planning.databases.remove', ['projectId' => $project->id_project, 'databaseId' => $projectDatabase->id_database]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @error('name')
                                            <p>{{ $message }}</p>
                                        @enderror
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No databases found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="container-fluid py-4">
                            <p class="mb-0">Suggest a new Data Base:</p>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Data Base name:</label>
                                    <input class="form-control" type="text" name="description">
                                    <input class="form-control" type="hidden" name="id_project"
                                        value="{{ $id_project }}">
                                    <label for="example-text-input" class="form-control-label">Data Base Link:</label>
                                    <input class="form-control" type="text" name="description">
                                    <input class="form-control" type="hidden" name="id_project"
                                        value="{{ $id_project }}">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Send suggestion</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

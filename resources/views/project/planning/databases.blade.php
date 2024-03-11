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
                                action="{{ route('project.planning.databases.add', ['projectId' => $project->id_project]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control" name="databaseId">
                                                @forelse ($databases as $database)
                                                    @if ($database->state == 'approved')
                                                        <option value="{{ $database->id_database }}">
                                                            {{ $database->name }}
                                                        </option>
                                                    @endif
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
                                                    action="{{ route('project.planning.databases.remove', ['database' => $projectDatabase, 'projectId' => $project->id_project]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
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
                            <p class="mb-0">Suggest a new Database:</p>
                            <div class="col-md-6">
                                <form
                                    action="{{ route('project.planning.databases.store', ['projectId' => $project->id_project]) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="db_name" class="form-control-label">Database Name:</label>
                                        <input class="form-control" type="text" name="db_name" id="db_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="db_link" class="form-control-label">Database Link:</label>
                                        <input class="form-control" type="text" name="db_link" id="db_link">
                                    </div>
                                    <input class="form-control" type="hidden" name="id_project"
                                        value="{{ $id_project }}">
                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Send
                                        suggestion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

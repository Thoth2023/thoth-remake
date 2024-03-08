<div class="card-body col-md-6 pt-3">
    <div class="card">
        <form role="form" action="{{ route('project.planning_overall.languageAdd') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">Languages</p>
                        @include ('components.help-button', ['dataTarget' => 'LanguageModal'])
                        <!-- Help Button Description -->
                        @include(
                        'components.help-modal',
                        [
                            'modalId' => 'LanguageModal',
                            'modalLabel' => 'exampleModalLabel',
                            'modalTitle' => 'Help for Keywords',
                            'modalContent' => 'test'
                            ]
                        )
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="id_language">
                                @forelse ($languages as $language)
                                    <option value="{{ $language->id_language }}">{{ $language->description }}</option>
                                @empty
                                    <option>No languages in the database.</option>
                                @endforelse
                            </select>
                            <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                        </div>
                        <button type="submit" class="btn btn-success mt-1">Add</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Languages</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projectLanguages as $projectLanguage)
                        <tr>
                            <td>
                                <p class="text-sm font-weight-bold mb-0"><?= convert_language_name($projectLanguage->id_language) ?></p>
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('project.planning_overall.languageDestroy', $projectLanguage->id_language) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete language">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No languages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

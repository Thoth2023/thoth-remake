<div class="card-group card-frame mt-5">
    <div class="card">
        <form role="form" action="{{ route('project.planning_overall.languageAdd') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Languages</p>
                        <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#LanguageModal">?</button>
                        <!-- Help Button Description -->
                        <div class="modal fade" id="LanguageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Help for Languages</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Help content goes here -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Help Description Ends Here -->
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
                        <button type="submit" class="btn btn-success mt-3">Add</button>
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
    <hr class="horizontal dark">
</div>

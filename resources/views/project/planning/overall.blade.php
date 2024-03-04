
<!-- Domain starts here -->
<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-5">
                <div class="card">
                    <form role="form" method="POST"
                        action="{{ route('project.planning_overall.domainUpdate') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Domains</p>
                                    <button type="button" class="help-thoth-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#DomainModal">
                                        ?
                                    </button>
                                    <!-- Help Button Description -->
                                    <div class="modal fade" id="DomainModal"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">Help for
                                                        Domains</h5>
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
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input"
                                                class="form-control-label">Description</label>
                                            <input class="form-control" type="text"
                                                name="description">
                                            <input class="form-control" type="hidden"
                                                name="id_project"
                                                value="{{ $id_project }}">
                                        </div>
                                        <button type="submit"
                                        class="btn btn-success mt-3">Add</button>
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
                                            Description
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($domains as $domain)
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{
                                                $domain->description }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <button
                                                style="border:0; background: none; padding: 0px;"
                                                type="button"
                                                class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-form{{ $domain->id_domain }}"
                                                data-original-title="Edit domain">Edit</button>
                                            <!-- Modal Here Edition -->
                                            <div class="col-md-4">
                                                <div class="modal fade"
                                                    id="modal-form{{ $domain->id_domain }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="modal-form"
                                                    aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-md"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div
                                                                    class="card card-plain">
                                                                    <div
                                                                        class="card-header pb-0 text-left">
                                                                        <h3>Domain
                                                                            Update</h3>
                                                                    </div>
                                                                    <div
                                                                        class="card-body">
                                                                        <form
                                                                            role="form text-left"
                                                                            method="POST"
                                                                            action="{{ route('planning_overall.domainEdit', $domain->id_domain) }}">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <label>Domain</label>
                                                                            <div
                                                                                class="input-group mb-3">
                                                                                <input
                                                                                    class="form-control"
                                                                                    type="text"
                                                                                    name="description"
                                                                                    value="{{ $domain->description }}">
                                                                            </div>
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
                                            </div>
                                                <!-- Modal Ends Here -->
                                        </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('planning_overall.domainDestroy', $domain->id_domain) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        style="border:0; background: none; padding: 0px;"
                                                        type="submit"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip"
                                                        data-original-title="Delete domain">Delete</button>
                                                </form>
                                            </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No
                                                domains found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <hr class="horizontal dark">
                    </form>
                </div>
            </div>
                <!-- Domain ends here -->
                <!-- Language starts here -->
            <div class="card-group card-frame mt-5">
                <div class="card">
                    <form role="form"
                        action="{{ route('project.planning_overall.languageAdd') }}"
                        method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">Languages</p>
                                        <button type="button" class="help-thoth-button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#LanguageModal">
                                            ?
                                        </button>
                                        <!-- Help Button Description -->
                                        <div class="modal fade" id="LanguageModal"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div
                                                class="modal-dialog modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="exampleModalLabel">Help
                                                            for Languages</h5>
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
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control"
                                            name="id_language">
                                            @forelse ($languages as $language)
                                            <option
                                            value="{{ $language->id_language }}">{{
                                            $language->description }}</option>
                                            @empty
                                            <option>No languages in database.</option>
                                            @endforelse
                                            </select>
                                            <input class="form-control"
                                            type="hidden" name="id_project"
                                            value="{{ $id_project }}">
                                        </div>
                                        <button type="submit"
                                        class="btn btn-success mt-3">Add</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                    <div class="table-responsive p-0">
                            <table
                            class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Languages
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($projectLanguages as $projectLanguage)
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0"><?=convert_language_name($projectLanguage->id_language)?></p>
                                        </td>
                                        <td class="align-middle">
                                            <form
                                                action="{{ route('planning_overall.languageDestroy', $projectLanguage->id_language) }}"
                                                method="POST">
                                                @csrf
                                            @method('DELETE')
                                                <button
                                                style="border:0; background: none; padding: 0px;"
                                                type="submit"
                                                class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip"
                                                data-original-title="Delete language">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No
                                            languages found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                </div>
                <hr class="horizontal dark">
            </div>
            <div class="card-group card-frame mt-5">
                <div class="card">
                    <form role="form" method="POST"
                        action="{{ route('project.planning_overall.studyTAdd') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Study type</p>
                                    <button type="button" class="help-thoth-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#StudyTypeModal">
                                        ?
                                    </button>
                                    <!-- Help Button Description -->
                                    <div class="modal fade" id="StudyTypeModal"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div
                                            class="modal-dialog modal-dialog-centered"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">Help
                                                        for Study type</h5>
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
                                                class="form-control-label">Types</label>
                                            <select class="form-control"
                                                name="id_study_type">
                                                @forelse ($studyTypes as $studyType)
                                                <option
                                                    value="{{ $studyType->id_study_type }}">{{
                                                    $studyType->description }}</option>
                                                @empty
                                                <option>No study types in database.</option>
                                                @endforelse
                                            </select>
                                            <input class="form-control"
                                                type="hidden" name="id_project"
                                                value="{{ $id_project }}">

                                        </div>
                                        <button type="submit"
                                        class="btn btn-success mt-3">Add</button>
                                    </div>
                                </form>
                                <div class="table-responsive p-0">
                                    <table
                                        class="table align-items-center justify-content-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Types
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($projectStudyTypes as $pStudyType)
                                            <tr>
                                                <td>
                                                    <p
                                                        class="text-sm font-weight-bold mb-0"><?=convert_study_type_name($pStudyType->id_study_type)?></p>
                                                </td>
                                                <td class="align-middle">
                                                    <form
                                                        action="{{ route('planning_overall.studyTDestroy', $pStudyType->id_study_type) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            style="border:0; background: none; padding: 0px;"
                                                            type="submit"
                                                            class="text-secondary font-weight-bold text-xs"
                                                            data-toggle="tooltip"
                                                            data-original-title="Delete domain">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No
                                                    domains found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-group card-frame mt-5">
                <div class="card">
                    <form role="form" method="POST"
                        action="{{ route('project.planning_overall.keywordAdd') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Keywords</p>
                                    <button type="button" class="help-thoth-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#KeywordModal">
                                        ?
                                    </button>
                                    <!-- Help Button Description -->
                                    <div class="modal fade" id="KeywordModal"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div
                                            class="modal-dialog modal-dialog-centered"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">Help
                                                        for Keywords</h5>
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
                                            <input class="form-control" type="text"
                                                name="description">
                                            <input class="form-control"
                                                type="hidden" name="id_project"
                                                value="{{ $id_project }}">

                                        </div>
                                        <button type="submit"
                                        class="btn btn-success mt-3">Add</button>
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
                                                    Keywords
                                                </th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($keywords as $keyword)
                                            <tr>
                                                <td>
                                                    <p
                                                        class="text-sm font-weight-bold mb-0">{{
                                                        $keyword->description }}</p>
                                                </td>
                                                <td class="align-middle">
                                                    <button
                                                        style="border:0; background: none; padding: 0px;"
                                                        type="button"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-form{{ $keyword->id_keyword }}"
                                                        data-original-title="Edit domain">Edit</button>
                                                    <!-- Modal Here Edition -->
                                                    <div class="col-md-4">
                                                        <div class="modal fade"
                                                            id="modal-form{{ $keyword->id_keyword }}"
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
                                                                                <h3>Keyword
                                                                                    Update</h3>
                                                                            </div>
                                                                            <div
                                                                                class="card-body">
                                                                                <form
                                                                                    role="form text-left"
                                                                                    method="POST"
                                                                                    action="{{ route('planning_overall.keywordEdit', $keyword->id_keyword) }}">
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <label>Keyword</label>
                                                                                    <div
                                                                                        class="input-group mb-3">
                                                                                        <input
                                                                                            class="form-control"
                                                                                            type="text"
                                                                                            name="description"
                                                                                            value="{{ $keyword->description }}">
                                                                                    </div>
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
                                                    </div>
                                                        <!-- Modal Ends Here -->
                                                </td>
                                                <td class="align-middle">
                                                        <form
                                                            action="{{ route('planning_overall.keywordDestroy', $keyword->id_keyword) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                style="border:0; background: none; padding: 0px;"
                                                                type="submit"
                                                                class="text-secondary font-weight-bold text-xs"
                                                                data-toggle="tooltip"
                                                                data-original-title="Delete keyword">Delete</button>
                                                        </form>
                                                </td>
                                            </tr>
                                                @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="text-center">No
                                                    keywords found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </form>
                </div>

                <hr class="horizontal dark">
            </div>
        </div>
    </div>
</div>

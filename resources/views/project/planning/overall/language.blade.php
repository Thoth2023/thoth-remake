<div class="card-body col-md-6 pt-3">
    <div class="card">
        <form role="form"
            action="{{ route('project.planning.languages.store', ['projectId' => $project->id_project]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">{{ __('project/planning.overall.language.title') }}</p>
                        @include ('components.help-button', ['dataTarget' => 'LanguageModal'])
                        <!-- Help Button Description -->
                        @include('components.help-modal', [
                            'modalId' => 'LanguageModal',
                            'modalLabel' => 'exampleModalLabel',
                            'modalTitle' => __('project/planning.overall.language.help.title'),
                            'modalContent' => __('project/planning.overall.language.help.content'),
                        ])
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
                                    <option>{{ __('project/planning.overall.language.list.empty') }}</option>
                                @endforelse
                            </select>
                            <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                        </div>
                        <button type="submit"
                            class="btn btn-success mt-1">{{ __('project/planning.overall.language.add') }}</button>
                    </div>

        </form>
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{ __('project/planning.overall.language.list.headers.languages') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($project->languages as $projectLanguage)
                        <tr>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">
                                    {{ $projectLanguage->description }}</p>
                            </td>
                            <td class="align-middle">
                                <form
                                    action="{{ route('project.planning.languages.destroy', [
                                        'language' => $projectLanguage,
                                        'projectId' => $project->id_project,
                                    ]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 7px;" class="btn btn-outline-danger btn-group-sm btn-sm m-1"
                                        class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                        data-original-title="{{ __('project/planning.overall.language.list.actions.delete.button') }}">
                                        {{ __('project/planning.overall.language.list.actions.delete.button') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                {{ __('project/planning.overall.language.list.empty') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>

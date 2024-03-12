<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-1">
                <div class="card">
                    <div>
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0">{{ __('project/planning.research-questions.title') }}</p>
                                @include ('components.help-button', [
                                    'dataTarget' => 'ResearchQuestionModal',
                                ])
                                <!-- Help Button Description -->
                                @include('components.help-modal', [
                                    'modalId' => 'ResearchQuestionModal',
                                    'modalLabel' => 'exampleModalLabel',
                                    'modalTitle' => __('project/planning.research-questions.help.title'),
                                    'modalContent' => __('project/planning.research-questions.help.content'),
                                ])
                            </div>
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST"
                                action="{{ route('project.planning.research-questions.store', ['projectId' => $project->id_project]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input"
                                                class="form-control-label">{{ __('project/planning.research-questions.form.id') }}</label>
                                            <input class="form-control" type="text" name="id" required>
                                            <label for="example-text-input"
                                                class="form-control-label">{{ __('project/planning.research-questions.form.description') }}</label>
                                            <input class="form-control" type="text" name="description" required>
                                            <input class="form-control" type="hidden" name="id_project"
                                                value="{{ $id_project }}">
                                        </div>
                                        <button type="submit"
                                            class="btn btn-success mt-3">{{ __('project/planning.research-questions.form.add') }}</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('project/planning.research-questions.table.id') }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('project/planning.research-questions.table.description') }}
                                            </th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($project->researchQuestions as $researchQuestion)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $researchQuestion->id }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">
                                                        {{ $researchQuestion->description }}</p>
                                                </td>
                                                <td class="col-md-auto d-flex">
                                                    <button
                                                        type="button" style="padding: 7px;" class="btn btn-outline-secondary btn-group-sm btn-sm m-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-form{{ $researchQuestion->id_research_question }}"
                                                        data-original-title="{{ __('project/planning.research-questions.table.edit') }}">{{ __('project/planning.research-questions.table.edit') }}</button>
                                                    <!-- Modal Here Edition -->
                                                    <div class="col-md-auto d-flex">
                                                        <div class="modal fade"
                                                            id="modal-form{{ $researchQuestion->id_research_question }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="modal-form"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-md"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body p-0">
                                                                        <div class="card card-plain">
                                                                            <div class="card-header pb-0 text-left">
                                                                                <h3>{{ __('project/planning.research-questions.edit-modal.title') }}
                                                                                </h3>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <form role="form text-left"
                                                                                    method="POST"
                                                                                    action="{{ route('project.planning.research-questions.update', ['research_question' => $researchQuestion, 'projectId' => $project->id_project]) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <label>{{ __('project/planning.research-questions.edit-modal.id') }}</label>
                                                                                    <div class="input-group mb-3">
                                                                                        <input class="form-control"
                                                                                            type="text"
                                                                                            name="id"
                                                                                            value="{{ $researchQuestion->id }}"
                                                                                            required>
                                                                                    </div>
                                                                                    <label>{{ __('project/planning.research-questions.edit-modal.description') }}</label>
                                                                                    <div class="input-group mb-3">
                                                                                        <input class="form-control"
                                                                                            type="text"
                                                                                            name="description"
                                                                                            value="{{ $researchQuestion->description }}"
                                                                                            required>
                                                                                    </div>
                                                                                    <input type="hidden"
                                                                                        name="id_project"
                                                                                        value="{{ $researchQuestion->id_project }}">
                                                                                    <div class="text-center">
                                                                                        <button type="submit"
                                                                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">{{ __('project/planning.research-questions.edit-modal.update') }}</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Ends Here -->
                                                    </div>

                                                    <form
                                                        action="{{ route('project.planning.research-questions.destroy', ['research_question' => $researchQuestion, 'projectId' => $project->id_project]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit" style="padding: 7px;"
                                                            class="btn btn-outline-danger btn-group-sm btn-sm m-1"
                                                            data-toggle="tooltip"
                                                            data-original-title="{{ __('project/planning.research-questions.table.delete') }}">{{ __('project/planning.research-questions.table.delete') }}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    {{ __('project/planning.research-questions.table.no-questions') }}
                                                </td>
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
    </div>
</div>

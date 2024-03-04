<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-5">
                                        <div class="card">
                                            <form role="form" method="POST" action="{{ route('project.planning_research.Add') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div>
                                                    <div class="card-header pb-0">
                                                        <div class="d-flex align-items-center">
                                                            <p class="mb-0">Research Questions</p>
                                                            <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#ResearchQuestionsModal">
                                                                ?
                                                            </button>
                                                            <!-- Help Button Description -->
                                                            <div class="modal fade" id="ResearchQuestionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Help for Research Questions</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        ...
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
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="example-text-input" class="form-control-label">ID</label>
                                                                    <input class="form-control" type="text" name="id" required>
                                                                    <label for="example-text-input" class="form-control-label">Description</label>
                                                                    <input class="form-control" type="text" name="description" required>
                                                                    <input clas="form-control" type="hidden" name="id_project" value="{{ $id_project }}">

                                                                </div>
                                                                <button type="submit" class="btn btn-success mt-3">Add</button>
                                                            </div>
                                                            </form>
                                                            <div class="table-responsive p-0">
                                                                <table class="table align-items-center justify-content-center mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                ID
                                                                            </th>
                                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                Description
                                                                            </th>
                                                                            <th></th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse ($project->researchQuestions as $researchQuestion)
                                                                        <tr>
                                                                            <td>
                                                                                <p class="text-sm font-weight-bold mb-0">{{ $researchQuestion->id }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <p class="text-sm font-weight-bold mb-0">{{ $researchQuestion->description }}</p>
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                <button style="border:0; background: none; padding: 0px;" type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-form{{ $researchQuestion->id_research_question }}" data-original-title="Edit research">Edit</button>
                                                                                <!-- Modal Here Edition -->
                                                                                <div class="col-md-4">
                                                                                    <div class="modal fade" id="modal-form{{ $researchQuestion->id_research_question }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                        <div class="modal-content">
                                                                                        <div class="modal-body p-0">
                                                                                            <div class="card card-plain">
                                                                                            <div class="card-header pb-0 text-left">
                                                                                                <h3>Research Question Update</h3>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <form role="form text-left" method="POST" action="{{ route('planning_research.Edit', $researchQuestion->id_research_question) }}">
                                                                                                    @csrf
                                                                                                    @method('PUT')
                                                                                                    <label>ID</label>
                                                                                                    <div class="input-group mb-3">
                                                                                                        <input class="form-control" type="text" name="id" value="{{ $researchQuestion->id }}" required>
                                                                                                    </div>
                                                                                                    <label>Description</label>
                                                                                                    <div class="input-group mb-3">
                                                                                                        <input class="form-control" type="text" name="description" value="{{ $researchQuestion->description }}" required>
                                                                                                    </div>
                                                                                                    <input type="hidden" name="id_project" value="{{ $researchQuestion->id_project }}">
                                                                                                    <div class="text-center">
                                                                                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update</button>
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
                                                                                <form action="{{ route('planning_research.Destroy', $researchQuestion->id_research_question) }}" method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete Research">Delete</button>
                                                                                </form>
                                                                            </td>
                                                                        </tr>
                                                                        @empty
                                                                        <tr>
                                                                            <td colspan="5" class="text-center">No research questions found.</td>
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
</div>

<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-5">
                <!-- create data extraction -->
                <div class="card">
                    <div class="card-header">
                        <h5>Create Data Extraction Question</h5>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST"
                            action="{{ route('project.planning.dataExtractionCreate', $project->id_project) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <label class="form-control-label" for="id">ID</label>
                            <input class="form-control" id="id" type="text"
                                name="id">
                            <label class="form-control-label" for="description">Description</label>
                            <input class="form-control" id="description"
                                type="text" name="description">
                            <label class="form-control-label" for="type">Type</label>
                            <select class="form-control" name="type" id="type"
                                placeholder="Departure">

                            </select>
                            <button type="sumbit" class="btn btn-success mt-3">Add
                                Question</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Create Data Extraction Question Option</h5>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST"
                            action="{{ route('project.planning.dataExtractionOptionCreate', $project->id_project) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <label class="form-control-label" for="question-id">Question</label>
                            <select class="form-control" name="questionId"
                                id="question-id" placeholder="Departure">
                                <option value selected></option>
                                @foreach($project->questionExtractions as $question)
                                @if ($question->question_type->type =="Multiple Choice List" || $question->question_type->type == "Pick One List")
                                <option value="{{ $question->id_de }}">{{$question->id }}</option>
                                @endif
                                @endforeach
                            </select>
                            <label class="form-control-label" for="option">Option</label>
                            <input class="form-control" id="option" type="text"
                                name="option">
                            <button type="sumbit" class="btn btn-success mt-3">Add
                                option</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mt-3 p-4">
                <ul class="list-group">
                    <li class="list-group-item m-1">
                        <div class="row">
                            <div class="col-1">
                                <b>ID</b>
                            </div>
                            <div class="col">
                                <b>Description</b>
                            </div>
                            <div class="col">
                                <b>Question Type</b>
                            </div>
                            <div class="col-5">
                                <b>Options</b>
                            </div>
                            <div class="col-md-auto">
                                <b>Actions</b>
                            </div>
                        </div>
                    </li>
                    @foreach($project->questionExtractions as $question)
                    <li class="list-group-item m-1">
                        <div class="row">
                            <div class="col-1">
                                <span>{{ $question->id }}</span>
                            </div>
                            <div class="col">
                                <span>{{ $question->description }}</span>
                            </div>
                            <div class="col">
                                <span>{{ $question->question_type->type }}</span>
                            </div>
                            <div class="col-5">
                                <ul class="list-group">
                                    @foreach($question->options as $option)
                                    <li class="list-group-item m-1">
                                        <div class="row">
                                            <div class="col">
                                                <span>{{ $option->description }}</span>
                                            </div>
                                            <div class="col-md-auto d-flex">
                                                <form class="m-1" role="form"
                                                    method="POST"
                                                    action="{{ route('project.planning.dataExtractionUpdateOption', [$project->id_project, $option->id_option]) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button"
                                                        class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#optionModal">Edit</button>
                                                    <div class="modal fade"
                                                        id="optionModal"
                                                        tabindex="-1"
                                                        role="dialog"
                                                        aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered"
                                                            role="document">
                                                            <div
                                                                class="modal-content">
                                                                <div
                                                                    class="modal-header">
                                                                    <h5
                                                                        class="modal-title"
                                                                        id="exampleModalLabel">Edit
                                                                        Option</h5>
                                                                </div>
                                                                <div
                                                                    class="modal-body">
                                                                    <label
                                                                        class="form-control-label"
                                                                        for="option">Option</label>
                                                                    <input
                                                                        class="form-control"
                                                                        type="text"
                                                                        id="option"
                                                                        name="option"
                                                                        value="{{ $option->description }}">
                                                                </div>
                                                                <div
                                                                    class="modal-footer">
                                                                    <button
                                                                        type="button"
                                                                        class="btn bg-gradient-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button
                                                                        type="submit"
                                                                        class="btn bg-gradient-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form class="m-1" role="form"
                                                    method="POST"
                                                    action="{{ route('project.planning.dataExtractionDeleteOption', [$project->id_project, $option->id_option]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-auto d-flex">
                                <form class="m-1" role="form" method="POST"
                                    action="{{ route('project.planning.dataExtractionUpdateQuestion', [$project->id_project, $question->id_de]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <button type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#questionModal">Edit</button>
                                    <div class="modal fade" id="questionModal"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div
                                            class="modal-dialog modal-dialog-centered"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">Edit
                                                        Question</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <label
                                                        class="form-control-label"
                                                        for="id">ID</label>
                                                    <input class="form-control"
                                                        id="id"
                                                        value="{{ $question->id }}"
                                                        name="id">
                                                    <label
                                                        class="form-control-label"
                                                        for="description">Description</label>
                                                    <input class="form-control"
                                                        id="description"
                                                        value="{{ $question->description }}"
                                                        name="description">
                                                    <label
                                                        class="form-control-lavel"
                                                        for="type">Type</label>
                                                    <select class="form-control"
                                                        name="type" id="type"
                                                        placeholder="Departure">
                                                        <option
                                                            value="{{ $question->question_type->id_type }}"
                                                            selected>{{
                                                            $question->question_type->type
                                                            }}</option>
                                                        @foreach($types as $type)
                                                        @if ($type->id_type !== $question->question_type->id_type)
                                                        <option
                                                            value="{{ $type->id_type }}">{{
                                                            $type->type }}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn bg-gradient-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn bg-gradient-primary">Save
                                                        changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form class="m-1" role="form" method="POST"
                                    action="{{ route('project.planning.dataExtractionDeleteQuestion', [$project->id_project, $question->id_de]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

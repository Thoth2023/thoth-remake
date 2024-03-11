<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-1">
                <!-- create data extraction -->
                @include('project.planning.data-extraction.partials.data-extraction-question-form')
                @include('project.planning.data-extraction.partials.data-extraction-option-form', [
                    'project' => $project,
                ])
                <div class="card-body col-md-12">
                    <ul class="list-group">
                        <li class="list-group-item">
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
                        @foreach ($project->questions as $question)
                            @include('project.planning.data-extraction.partials.data-extraction-question', [
                                'question' => $question,
                                'project' => $project,
                                'types' => $questionTypes,
                            ])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

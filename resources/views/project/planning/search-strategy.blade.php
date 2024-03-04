<div class="container-fluid py-4">
        <div class="d-flex justify-content-between">
            <p class="text-uppercase text-sm">Search Strategy</p>
            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapseHelp" role="button" aria-expanded="false" aria-controls="collapseHelp">
                <i class="fas fa-question-circle"></i> Help
            </a>
        </div>
        <div class="collapse" id="collapseHelp">
            <div class="card card-body mb-4 p-3">
                <div class="modal-body">
                    <p>In the planning phase, it is necessary to determine and follow a search strategy. This should be developed in consultation with librarians or others with relevant experience. Search strategies are usually iterative and benefit from:</p>
                    <ul>
                        <li>Conducting preliminary searches aimed at both identifying existing systematic reviews and assessing the volume of potentially relevant studies.</li>
                        <li>Performing trial searches using various combinations of search terms derived from the research question.</li>
                        <li>Cross-checking the trial research string against lists of already known primary studies.</li>
                        <li>Seeking consultations with experts in the field.</li>
                    </ul>
                    <p>Describe here the strategy that will be used in your research.</p>
                </div>
            </div>
        </div>
        @if(session()->has('message'))
        <div class="alert alert-{{ session('message_type') }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <form method="POST" action="{{ route('project.search-strategy.update', ['projectId' => $project->id_project]) }}">
            @csrf
            @method('post')
            <div class="form-group">
                <label for="searchStrategyTextarea">Search Strategy</label>
                <textarea name="search_strategy" class="form-control @error('search_strategy') is-invalid @enderror" id="searchStrategyTextarea" rows="8" placeholder="Enter the search strategy">{{ $project->searchStrategy->description ?? old('search_strategy') }}</textarea>

                @error('search_strategy')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="d-flex align-items-center mt-4">
                <button type="submit" class="btn btn-success mt-3">
                    Save
                </button>
            </div>
        </form>
</div>

<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-1">
                <div class="card">
                    <div>
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0">{{ __('project/planning.search-strategy.title') }}</p>
                                @include ('components.help-button', ['dataTarget' => 'SearchStrategyHelpModal'])
                                <!-- Help Button Description -->
                                @include('components.help-modal', [
                                    'modalId' => 'SearchStrategyHelpModal',
                                    'modalLabel' => 'exampleModalLabel',
                                    'modalTitle' => __('project/planning.search-strategy.help.title'),
                                    'modalContent' => __('project/planning.search-strategy.help.content'),
                                ])
                            </div>
                        </div>
                        <div class="container-fluid py-4">
                            @if (session()->has('message'))
                                <div class="alert alert-{{ session('message_type') }} alert-dismissible fade show"
                                    role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form method="POST"
                                action="{{ route('project.planning.search-strategy.update', ['projectId' => $project->id_project]) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <textarea name="search_strategy" class="form-control @error('search_strategy') is-invalid @enderror"
                                        id="searchStrategyTextarea" rows="8" placeholder="{{ __('project/planning.search-strategy.placeholder') }}">{{ $project->searchStrategy->description ?? old('search_strategy') }}</textarea>

                                    @error('search_strategy')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <button type="submit" class="btn btn-success mt-3">
                                        {{ __('project/planning.search-strategy.save-button') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


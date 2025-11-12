@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __('project/create.create_project')])
    <div class="card shadow-lg mx-4 mt-5">
        <div class="container-fluid py-4">

            <p class="text-uppercase text-sm">{{ __('project/create.create_project') }}</p>
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="titleInput">{{ __('project/create.title') }}</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                           id="titleInput" placeholder="{{ __('project/create.enter_title') }}" value="{{ old('title') }}">

                    @error('title')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descriptionTextarea">{{ __('project/create.description') }}</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              id="descriptionTextarea" rows="3"
                              placeholder="{{ __('project/create.enter_description') }}">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="objectivesTextarea">{{ __('project/create.objectives') }}</label>
                    <textarea name="objectives" class="form-control @error('objectives') is-invalid @enderror"
                              id="objectivesTextarea" rows="3"
                              placeholder="{{ __('project/create.enter_objectives') }}">{{ old('objectives') }}</textarea>
                    @error('objectives')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="copy_planning">{{ __('project/create.copy_planning') }}</label>
                    <select class="form-control" id="copy_planning" name="copy_planning">
                        @if(count($projects) > 0)
                            <option value="none">{{ __('project/create.none') }}</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id_project }}">{{ $project->title }}</option>
                            @endforeach
                        @else
                            <option value="none">{{ __('project/create.noProjects') }}</option>
                        @endif
                    </select>
                </div>

                <hr class="horizontal dark mt-4">
                <p class="text-uppercase text-sm">{{ __('project/create.type_project') }}</p>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review1"
                           value="Systematic review" {{ old('feature_review') == 'Systematic review' ? 'checked' : '' }}>
                    <label class="form-check-label" for="feature_review1">
                        {{ __('project/create.systematicReview') }}
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review2"
                           value="Systematic review and Snowballing" {{ old('feature_review') == 'Systematic review and Snowballing' ? 'checked' : '' }}>
                    <label class="form-check-label" for="feature_review2">
                        {{ __('project/create.systematicAndSnowballing') }}
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review3"
                           value="Snowballing" {{ old('feature_review') == 'Snowballing' ? 'checked' : '' }}>
                    <label class="form-check-label" for="feature_review3">
                        {{ __('project/create.snowballing') }}
                    </label>
                </div>

                <hr class="horizontal dark mt-4">
                <p class="text-uppercase text-sm">{{ __('project/public_protocol.project_visibility') }}</p>

                <div class="form-check form-switch ps-0">
                    <div class="d-flex align-items-center gap-3">
                        <input class="form-check-input ms-0" type="checkbox" role="switch" name="is_public"
                               id="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-eye"></i>
                            <label class="form-check-label mb-0" for="is_public">
                                {{ __('project/public_protocol.make_public') }}
                            </label>
                            <i class="fas fa-question-circle text-warning"
                               data-bs-toggle="tooltip" data-bs-placement="right"
                               title="{{ __('project/public_protocol.visibility_tooltip') }}"></i>
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark mt-4">
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-secondary btn-sm me-2"
                            onclick="window.location='{{ route('projects.index') }}'">
                        {{ __('project/edit.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">
                        {{ __('project/create.create') }}
                    </button>
                </div>
            </form>

            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

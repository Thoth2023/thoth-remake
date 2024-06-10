@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create Project'])
    <div class="card shadow-lg mx-4">
        <div class="container-fluid py-4">
            <p class="text-uppercase text-sm">{{ __('pages/project.create_project') }}</p>
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="titleInput">{{ __('pages/project.title') }}</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        id="titleInput" placeholder="{{ __('pages/project.enter_the_title') }}" value="{{ old('title') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="descriptionTextarea">{{ __('pages/project.description') }}</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="descriptionTextarea"
                        rows="3" placeholder="{{ __('pages/project.enter_the_description') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="objectivesTextarea">{{ __('pages/project.objectives') }}</label>
                    <textarea name="objectives" class="form-control @error('objectives') is-invalid @enderror" id="objectivesTextarea"
                        rows="3" placeholder="{{ __('pages/project.enter_the_objectives') }}">{{ old('objectives') }}</textarea>
                    @error('objectives')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="copyPlanningSelect">{{ __('pages/project.copy_planning') }}</label>
                    <select class="form-control" id="copyPlanningSelect">
                        <option>{{ __('pages/project.option') }} 1</option>
                        <option>{{ __('pages/project.option') }} 2</option>
                        <option>{{ __('pages/project.option') }} 3</option>
                        <option>{{ __('pages/project.option') }} 4</option>
                        <option>{{ __('pages/project.option') }} 5</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">{{ __('pages/project.create') }}</button>
                </div>
            </form>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

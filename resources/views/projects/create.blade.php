@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __('project/create.create_project') ])
    <div class="card shadow-lg mx-4">
        <div class="container-fluid py-4">
            <p class="text-uppercase text-sm">{{ __('project/create.create_project')}}</p>
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="titleInput">{{ __('project/create.title')}}</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        id="titleInput" placeholder="{{ __('project/create.enter_title')}}" value="{{ old('title') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="descriptionTextarea">{{ __('project/create.description')}}</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="descriptionTextarea"
                        rows="3" placeholder="{{ __('project/create.enter_description')}}">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="objectivesTextarea">{{ __('project/create.objectives')}}</label>
                    <textarea name="objectives" class="form-control @error('objectives') is-invalid @enderror" id="objectivesTextarea"
                        rows="3" placeholder="{{ __('project/create.enter_objectives')}}">{{ old('objectives') }}</textarea>
                    @error('objectives')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
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
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review1" value = "Systematic review">
                    {{ old('feature_review') == 'Systematic review' ? 'checked' : '' }}</input>
                    <label class="form-check-label" for="feature_review1" >
                        Systematic review
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review2"  value = "Systematic review and Snowballing">
                    {{ old('feature_review') == 'Systematic review and Snowballing' ? 'checked' : '' }}</input>
                    <label class="form-check-label" for="feature_review2">
                        Systematic review and Snowballing
                    </label>
                </div> 
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review3"  value= "Snowballing">
                    {{ old('feature_review') == 'Snowballing' ? 'checked' : '' }}</input>
                    <label class="form-check-label" for="feature_review3">
                         Snowballing
                    </label>
                </div>    
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Create</button>
                </div>
            </form>
            @include('layouts.footers.auth.footer')
        </div>
    </div>

@endsection
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' =>  __('nav/topnav.edit')])
    <div class="card shadow-lg mx-4">
        <div class="container-fluid py-4">
            <p class="text-uppercase text-sm">{{ __('nav/topnav.edit')}}</p>
            <form method="POST" action="{{ route('projects.update', $project->id_project) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="titleInput"> {{ __('project/edit.title')}}</label>
                    <input name="title" value="{{ $project->title }}" type="text" class="form-control" id="titleInput"
                        placeholder="{{ __('project/edit.enter_title') }}">
                </div>
                <div class="form-group">
                    <label for="descriptionTextarea">{{ __('project/edit.description')}}</label>
                    <textarea name="description" class="form-control" id="descriptionTextarea" rows="3"
                        placeholder="{{ __('project/edit.enter_description') }}">{{ $project->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="objectivesTextarea">{{ __('project/edit.objectives')}}</label>
                    <textarea name="objectives" class="form-control" id="objectivesTextarea" rows="3"
                        placeholder="{{ __('project/edit.enter_objectives') }}">{{ $project->objectives }}</textarea>
                </div>
                <div class="form-group">
                    <label for="copy_planning">{{ __('project/edit.copy_planning') }}</label>
                    <select class="form-control" id="copy_planning" name="copy_planning">
                        @if(count($projects) > 1)
                            <option value="none">{{ __('project/edit.none') }}</option>
                            @foreach($projects as $project_option)
                                @if (!($project_option->id_project == $project->id_project))
                                    <option value="{{ $project_option->id_project }}">{{ $project_option->title }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach($projects as $project_option)
                                <option value="none">{{ $project_option->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review1" value = "Systematic review">
                    {{ old('feature_review') == 'Systematic review'}}</input>
                    <label class="form-check-label" for="feature_review1" >
                        Systematic review
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review2"  value = "Systematic review and Snowballing">
                    {{ old('feature_review') == 'Systematic review and Snowballing'}}</input>
                    <label class="form-check-label" for="feature_review2">
                        Systematic review and Snowballing
                    </label>
                </div> 
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="feature_review" id="feature_review3"  value= "Snowballing">
                    {{ old('feature_review') == 'Snowballing'}}</input>
                    <label class="form-check-label" for="feature_review3">
                         Snowballing
                    </label>
                </div> 

                <hr class="horizontal dark mt-4">
                <p class="text-uppercase text-sm">{{ __('project.project_visibility') }}</p>
                
                <div class="form-check form-switch ps-0">
                    <div class="d-flex align-items-center gap-3">
                        <input class="form-check-input ms-0" type="checkbox" role="switch" name="is_public" id="is_public" value="1"
                            {{ $project->is_public ? 'checked' : '' }}>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-eye"></i>
                            <label class="form-check-label mb-0" for="is_public">
                                {{ __('project.make_public') }}
                            </label>
                            <i class="fas fa-question-circle text-warning" data-bs-toggle="tooltip" data-bs-placement="right"
                               title="{{ __('project.visibility_tooltip') }}"></i>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center mt-4">
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">{{ __('project/edit.edit')}}</button>
                </div>
            </form>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

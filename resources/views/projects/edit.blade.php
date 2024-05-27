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
                        placeholder="Enter the title">
                </div>
                <div class="form-group">
                    <label for="descriptionTextarea">{{ __('project/edit.description')}}</label>
                    <textarea name="description" class="form-control" id="descriptionTextarea" rows="3"
                        placeholder="Enter the description">{{ $project->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="objectivesTextarea">{{ __('project/edit.objectives')}}</label>
                    <textarea name="objectives" class="form-control" id="objectivesTextarea" rows="3"
                        placeholder="Enter the objectives">{{ $project->objectives }}</textarea>
                </div>
                <div class="form-group">
                    <label for="copyPlanningSelect">{{ __('project/edit.copy_planning')}}</label>
                    <select class="form-control" id="copyPlanningSelect" disabled>
                        <option>{{ __('project/edit.option_1')}}</option>
                        <option>{{ __('project/edit.option_2')}}</option>
                        <option>{{ __('project/edit.option_3')}}</option>
                        <option>{{ __('project/edit.option_4')}}</option>
                        <option>{{ __('project/edit.option_5')}}</option>
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
                
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">{{ __('project/edit.edit')}}</button>
                </div>
            </form>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

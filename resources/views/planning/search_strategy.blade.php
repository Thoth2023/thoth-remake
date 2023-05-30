@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Search Strategy'])
<div class="card shadow-lg mx-4">
    <div class="container-fluid py-4">
        <p class="text-uppercase text-sm">Search Strategy</p>
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            <div class="form-group">
                <label for="titleInput">Search Strategy</label>
                <textarea name="search_strategy" class="form-control @error('search_strategy') is-invalid @enderror" id="searchStrategyTextarea" rows="8" placeholder="Enter the search strategy">{{old('search_strategy')}}</textarea>
                @error('search_strategy')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-inline container-fluid justify-content-between">
                <a href="#tab_search_string" class="btn btn-secondary active show"><span class="fas fa-backward"></span> Previous</a>
                <a href="#tab_criteria" class="btn btn-secondary opt">Next <span class="fas fa-forward"></span></a>
            </div>
            <div class="d-flex align-items-center mt-4">
                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                <a onclick="modal_help('modal_help_strategy')" class="btn btn-secondary btn-sm me-2 opt"><i class="fas fa-question-circle"></i> Help</a>
            </div>
        </form>
        @include('layouts.footers.auth.footer')
    </div>
</div>
@endsection


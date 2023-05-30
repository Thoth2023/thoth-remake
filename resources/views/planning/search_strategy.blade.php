@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Search Strategy'])
    <div class="card shadow-lg mx-4">
        <div class="container-fluid py-4">
            <p class="text-uppercase text-sm">Search Strategy</p>
            <form method="POST" action="{{ route('search-strategy.update', $project->id_project) }}">
                @csrf
                <div class="form-group">
                    <label for="searchStrategyTextarea">Search Strategy</label>
                    <textarea name="search_strategy" class="form-control @error('search_strategy') is-invalid @enderror" id="searchStrategyTextarea" rows="8" placeholder="Enter the search strategy">{{ $searchStrategy->description ?? old('search_strategy') }}</textarea>
                    @error('search_strategy')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
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


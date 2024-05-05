@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create Project'])
    <div class="card shadow-lg mx-4">
        <div class="container-fluid py-4">
            <p class="text-uppercase text-sm">Create Project</p>
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="titleInput">Title</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        id="titleInput" placeholder="Enter the title" value="{{ old('title') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="descriptionTextarea">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="descriptionTextarea"
                        rows="3" placeholder="Enter the description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="objectivesTextarea">Objectives</label>
                    <textarea name="objectives" class="form-control @error('objectives') is-invalid @enderror" id="objectivesTextarea"
                        rows="3" placeholder="Enter the objectives">{{ old('objectives') }}</textarea>
                    @error('objectives')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="copyPlanningSelect">Copy Planning</label>
                    <select class="form-control" id="copyPlanningSelect" name="copy_planning">
                        @if(count($projects) > 0)
                            <option>Nenhum</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        @else
                            <option disabled selected>Usuário ainda não tem projetos criados</option>
                        @endif
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Create</button>
                </div>
            </form>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

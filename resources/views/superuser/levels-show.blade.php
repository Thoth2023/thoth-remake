@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => __("nav/side.view_permission")])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5 class="mb-0">{{ __("superuser/levels.details_group") }}</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="idGroup">ID</label>
                        <input type="text" class="form-control" id="idGroup" value="{{ $level->id_level }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nameGroup">Nome</label>
                        <input type="text" class="form-control" id="nameGroup" value="{{ $level->level }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="descriptionGroup">Descrição</label>
                        <input type="text" class="form-control" id="descriptionGroup" value="{{ $level->description }}" readonly>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('levels.index') }}" class="btn btn-primary">{{ __("superuser/levels.back") }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
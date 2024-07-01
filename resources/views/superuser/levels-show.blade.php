@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav',['title' => __("nav/side.view_permission")])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{__(superuser/levels.details_group)}}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <tr>
                            <th>ID</th>
                            <td>{{ $level->id_level }}</td>
                        </tr>
                        <tr>
                            <th>Nome</th>
                            <td>{{ $level->level }}</td>
                        </tr>
                        <tr>
                            <th>Descrição</th>
                            <td>{{ $level->description }}</td>
                        </tr>
                    </table>
                </div>
                <a href="{{ route('levels.index') }}" class="btn btn-primary mt-4">{{__(superuser/levels.back)}}</a>
            </div>
        </div>
    </div>
</div>
@endsection
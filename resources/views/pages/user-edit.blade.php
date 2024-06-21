@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => __('pages/profile.your_profile')])

<div class="container mt-8 mb-3">

    <div class="card shadow-lg ">
        <div class="card-body">
            <div class="row gx-4">
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname ? auth()->user()->firstname : auth()->user()->username }}
                            {{ auth()->user()->lastname ? auth()->user()->lastname : '' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                        Editando: {{ isset($user) ? $user->firstname . ' ' . $user->lastname : (auth()->user()->occupation ? auth()->user()->occupation : '') }}
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="row" style="justify-content: space-around;">
        <div class="col-md-12">
            <div class="card">
                <form role="form" method="POST" action={{ route('user.update', ['user' => $user->id]) }} enctype="multipart/form-data">
                    @csrf
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">{{ __('pages/profile.edit_profile') }}</p>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto" style="background-color:black;">{{ __('pages/profile.save') }}</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">{{ __('pages/profile.user_information') }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.user_name') }}</label>
                                    <input class="form-control" type="text" name="username" value="{{ old('username', $user->username) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.email') }}</label>
                                    <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.first_name') }}</label>
                                    <input class="form-control" type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.last_name') }}</label>
                                    <input class="form-control" type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.institution') }}</label>
                                    <input class="form-control" type="text" name="institution" value="{{ old('institution', $user->institution) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
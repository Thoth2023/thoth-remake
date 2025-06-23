@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => translationProfile('your_profile')])

<div class="container mt-8 mb-3">

	<!-- Displays the card header with the authenticated user's name and the name of the user being edited -->
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

	<!-- Displays the user edit form with basic details and role assignment -->
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
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0">{{ translationProfile('edit_profile') }}</p>
                            <div class="d-flex">
                                <button href="{{ route('user-manager') }}" class="btn btn-primary btn-sm ms-auto" style="background-color:red; margin-right:10px;">{{ translationProfile('cancel') }}</button>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto" style="background-color:black;">{{ translationProfile('save') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">{{ translationProfile('user_information') }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ translationProfile('user_name') }}</label>
                                    <input class="form-control" type="text" name="username" value="{{ old('username', $user->username) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ translationProfile('email') }}</label>
                                    <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ translationProfile('first_name') }}</label>
                                    <input class="form-control" type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ translationProfile('last_name') }}</label>
                                    <input class="form-control" type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ translationProfile('institution') }}</label>
                                    <input class="form-control" type="text" name="institution" value="{{ old('institution', $user->institution) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ translationProfile('permissions')}}</label>
                                    <select class="form-control" name="function">
                                        @foreach($roles as $key => $value)
                                            <option value="{{ $value }}" {{ old('function', $user->role) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
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

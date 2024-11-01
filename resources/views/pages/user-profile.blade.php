@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => __('pages/profile.your_profile')])

<div class="container mt-8 mb-3">

    <div class="card shadow-lg ">
        <div class="card-body">
            <div class="row gx-4">
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ auth()->user()->occupation ? auth()->user()->occupation : 'Occupation' }}
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
                <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                    @csrf
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">{{ __('pages/profile.edit_profile') }}</p>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto">{{ __('pages/profile.save') }}</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">{{ __('pages/profile.user_information') }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.username') }}</label>
                                    <input class="form-control" type="text" name="username" value="{{ old('username', auth()->user()->username) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.email') }}</label>
                                    <input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.first_name') }}</label>
                                    <input class="form-control" type="text" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.last_name') }}</label>
                                    <input class="form-control" type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">{{ __('pages/profile.contact_information') }}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address" class="form-control-label">{{ __('pages/profile.address') }}</label>
                                    <input id="autocomplete" class="form-control" type="text" name="address" value="{{ old('address', auth()->user()->address) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.city') }}</label>
                                    <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.country') }}</label>
                                    <input class="form-control" type="text" name="country" value="{{ old('country', auth()->user()->country) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.postal_code') }}</label>
                                    <input class="form-control" type="text" name="postal" value="{{ old('postal', auth()->user()->postal) }}">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">{{ __('pages/profile.about_me') }}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.about_me') }}</label>
                                    <input class="form-control" type="text" name="about" value="{{ old('about', auth()->user()->about) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.occupation') }}</label>
                                    <input class="form-control" type="text" name="occupation" value="{{ old('occupation', auth()->user()->occupation) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.institution') }}</label>
                                    <input class="form-control" type="text" name="institution" value="{{ old('institution', auth()->user()->institution) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.lattes_link') }}</label>
                                    <input class="form-control" type="text" id="lattes_link" name="lattes_link" value="{{ old('lattes_link', auth()->user()->lattes_link) }}">
                                    @error("lattes_link")
                                        <span class="text-xs text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
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

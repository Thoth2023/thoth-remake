@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="pb-3 text-start">
                                    <h4 class="font-weight-bolder">{{ __('auth/login.sign_in') }}</h4>
                                    <p class="mb-0">{{ __('auth/login.enter_email_password') }}</p>
                                </div>
                                <div class="pb-4">
                                    <form role="form" method="POST" action="{{ route('login.perform') }}">
                                        @csrf
                                        @method('post')
                                        <div class="flex flex-col mb-3">
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="{{ __('auth/login.email') }}" aria-label="Email"  value="{{ session('user_email') }}">
                                            @error('email')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                aria-label="{{ __('auth/login.password') }}"
                                                placeholder="{{ __('auth/login.password') }}">
                                            @error('password')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="remember" type="checkbox" id="remember">
                                            <label class="form-check-label"
                                                for="remember">{{ __('auth/login.remember_me') }}</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-dark btn-lg w-100 mt-4 mb-0">{{ __('auth/login.sign_in_button') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-1 text-sm mx-auto">
                                        {{ __('auth/login.forgot_password') }} <a href="{{ route('reset-password') }}"
                                            class="text-primary text-gradient font-weight-bold">{{ __('auth/login.reset_password_link') }}</a>
                                    </p>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        {{ __('auth/login.dont_have_account') }} <a href="{{ route('register') }}"
                                            class="text-primary text-gradient font-weight-bold">{{ __('auth/login.sign_up_link') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div
                                class="position-relative bg-gradient-light h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden">
                                <span class="mask bg-gradient-faded-dark opacity-8"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">
                                    {{ __('auth/login.app_description') }}</h4>
                                <p class="text-white position-relative">{{ __('auth/login.app_description_long') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

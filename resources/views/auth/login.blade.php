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

                                <div class="text-center px-lg-2 ">
                                    <p class="mb-1 text-sm mx-auto">
                                        {{ __('auth/login.forgot_password') }} <a href="{{ route('reset-password') }}"
                                            class="text-primary text-gradient font-weight-bold">{{ __('auth/login.reset_password_link') }}</a>
                                    </p>
                                    <p class="text-sm mx-auto">
                                        {{ __('auth/login.dont_have_account') }} <a href="{{ route('register') }}"
                                                                                    class="text-primary text-gradient font-weight-bold">{{ __('auth/login.sign_up_link') }}</a>
                                    </p>
                                </div>

                                <div class="position-relative text-center">
                                    <p class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                        {{ __('auth/register.or') }}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-12 px-1">
                                        <a class="btn btn-outline-light w-100" href="{{ route('auth.google') }}">
                                            <svg width="24px" height="32px" viewBox="0 0 64 64" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(3.000000, 2.000000)" fill-rule="nonzero">
                                                        <path
                                                            d="M57.8123233,30.1515267 C57.8123233,27.7263183 57.6155321,25.9565533 57.1896408,24.1212666 L29.4960833,24.1212666 L29.4960833,35.0674653 L45.7515771,35.0674653 C45.4239683,37.7877475 43.6542033,41.8844383 39.7213169,44.6372555 L39.6661883,45.0037254 L48.4223791,51.7870338 L49.0290201,51.8475849 C54.6004021,46.7020943 57.8123233,39.1313952 57.8123233,30.1515267"
                                                            fill="#4285F4"></path>
                                                        <path
                                                            d="M29.4960833,58.9921667 C37.4599129,58.9921667 44.1456164,56.3701671 49.0290201,51.8475849 L39.7213169,44.6372555 C37.2305867,46.3742596 33.887622,47.5868638 29.4960833,47.5868638 C21.6960582,47.5868638 15.0758763,42.4415991 12.7159637,35.3297782 L12.3700541,35.3591501 L3.26524241,42.4054492 L3.14617358,42.736447 C7.9965904,52.3717589 17.959737,58.9921667 29.4960833,58.9921667"
                                                            fill="#34A853"></path>
                                                        <path
                                                            d="M12.7159637,35.3297782 C12.0932812,33.4944915 11.7329116,31.5279353 11.7329116,29.4960833 C11.7329116,27.4640054 12.0932812,25.4976752 12.6832029,23.6623884 L12.6667095,23.2715173 L3.44779955,16.1120237 L3.14617358,16.2554937 C1.14708246,20.2539019 0,24.7439491 0,29.4960833 C0,34.2482175 1.14708246,38.7380388 3.14617358,42.736447 L12.7159637,35.3297782"
                                                            fill="#FBBC05"></path>
                                                        <path
                                                            d="M29.4960833,11.4050769 C35.0347044,11.4050769 38.7707997,13.7975244 40.9011602,15.7968415 L49.2255853,7.66898166 C44.1130815,2.91684746 37.4599129,0 29.4960833,0 C17.959737,0 7.9965904,6.62018183 3.14617358,16.2554937 L12.6832029,23.6623884 C15.0758763,16.5505675 21.6960582,11.4050769 29.4960833,11.4050769"
                                                            fill="#EB4335"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
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

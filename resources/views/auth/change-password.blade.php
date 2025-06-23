@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">
                                        {{ translationChangePassword('title') }}
                                    </h4>
                                    <p class="mb-0">
                                        {{ translationChangePassword('description') }}
                                    </p>
                                </div>
                                <div class="card-body">
                                <form role="form" method="POST" action="{{ route('change.perform', ['id' => request()->id]) }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ request()->id }}">
                                        <div class="flex flex-col mb-3">
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="{{ translationChangePassword('email') }}"
                                                value="{{ old('email') }}" aria-label="{{ __('auth.email') }}">
                                            @error('email')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                placeholder="{{ translationChangePassword('password') }}"
                                                aria-label="{{ __('auth.password') }}">
                                            @error('password')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <input type="password" name="confirm-password"
                                                class="form-control form-control-lg"
                                                placeholder="{{ translationChangePassword('confirm_password') }}"
                                                aria-label="{{ __('auth.confirm_password') }}">
                                            @error('confirm-password')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-dark btn-lg w-100 mt-4 mb-0">{{ translationChangePassword('send_reset') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="alert">
                                    @include('components.alert')
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div
                                class="position-relative bg-gradient-light h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden">
                                <span class="mask bg-gradient-faded-dark opacity-8"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">
                                    {{ translationChangePassword('quote.title') }}
                                </h4>
                                <p class="text-white position-relative">
                                    {{ translationChangePassword('quote.content') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

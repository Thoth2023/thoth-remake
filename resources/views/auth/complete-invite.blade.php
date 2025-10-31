@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')

    <main class="main-content mt-0">
        <div class="container mt-7 mb-3">

            {{-- Header igual ao registro --}}
            <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
                <div class="row justify-content-center rounded-3 py-4"
                     style="background-color: rgba(85, 101, 128, 1); width: 100%">
                    <div class="col-lg-6 text-center mx-auto">
                        <h1 class="text-white">{{ __('auth/invite.welcome') }}</h1>
                        <p class="text-lead text-white">{{ __('auth/invite.description') }}</p>
                    </div>
                </div>
            </div>

            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-12 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>{{ __('auth/invite.title') }}</h5>
                        </div>
                            <br/><br/>
                        <div class="card-body col-xl-6 col-lg-5 col-md-7 mx-auto">
                            <form method="POST" action="{{ route('invite.complete.save', $token) }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="text" name="firstname" class="form-control"
                                           placeholder="{{ __('auth/invite.firstname') }}" required>
                                    @error('firstname')
                                    <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="lastname" class="form-control"
                                           placeholder="{{ __('auth/invite.lastname') }}" required>
                                    @error('lastname')
                                    <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="{{ __('auth/invite.password') }}" required>

                                    @error('password')
                                    <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="{{ __('auth/invite.password_confirmation') }}" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-success w-50 my-2">
                                        {{ __('auth/invite.finish_button') }}
                                    </button>
                                </div>
                            </form>
                            <br/><br/><br/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @include('layouts.footers.guest.footer')
@endsection

@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container mt-8 mb-3">
            <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">

                <div class="row justify-content-center rounded-3 py-4"
                    style="background-color: rgba(85, 101, 128, 1); width: 100%">

                    <div class="col-lg-6 text-center mx-auto">
                        <h1 class="text-white">{{ __("auth/register.welcome") }}</h1>
                        <p class="text-lead text-white">{{ __("auth/register.description") }}</p>
                    </div>
                </div>
            </div>
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-12 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>{{ __('auth/register.register_with') }}</h5>
                        </div>
                        <div class="row px-xl-5 px-sm-4 px-3">

                            <div class="d-flex justify-content-center">
                                <div class="col-3 px-1">
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


                            <div class="mt-2 position-relative text-center">
                                <p class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                    {{ __('auth/register.or') }}
                                </p>
                            </div>
                        </div>
                        <div class="card-body col-xl-8 col-lg-5 col-md-7 mx-auto">
                            <form method="POST" action="{{ route('register.perform') }}" id="registerForm">
                                @csrf
                                <div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">

                                    <input type="text" name="firstname" class="form-control"
                                        placeholder="{{ __('auth/register.firstname') }}"
                                        aria-label="{{ __('auth.register.firstname') }}" value="{{ old('firstname') }}">
                                    @error('firstname')
                                        <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">
                                    <input type="text" name="lastname" class="form-control"
                                        placeholder="{{ __('auth/register.lastname') }}"
                                        aria-label="{{ __('auth.register.lastname') }}" value="{{ old('lastname') }}">
                                    @error('lastname')
                                        <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">
                                    <input type="text" name="institution" class="form-control"
                                        placeholder="{{ __('auth/register.institution') }}"
                                        aria-label="{{ __('auth.register.institution') }}" value="{{ old('institution') }}">
                                    @error('institution')
                                        <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ __('auth/register.email') }}"
                                        aria-label="{{ __('auth.register.email') }}" value="{{ old('email') }}">
                                    @error('email')
                                        <p class='text-danger text-xs pt-1'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">
                                    <input type="text" name="username" class="form-control"
                                        placeholder="{{ __('auth/register.username') }}"
                                        aria-label="{{ __('auth.register.username') }}" value="{{ old('username') }}">
                                    @error('username')
                                        <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto position-relative">
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="{{ __('auth/register.password') }}"
                                        aria-label="{{ __('auth.register.password') }}">
                                    <small id="passwordStrength" class="text-muted">Digite uma senha segura</small>
                                    <span role="button" id="togglePassword"
                                        class="position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor: pointer; background: white; display: none;"
                                        tabindex="-1">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </span>
                                    @error('password')
                                        <p class='text-danger text-xs pt-1'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-check form-check-info text-start col-xl-6 col-lg-5 col-md-6 mx-auto">
                                    <input class="form-check-input" type="checkbox" name="terms" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <!-- TODO: Add link to terms and conditions -->
                                        {{ __('auth/register.i_agree') }}
                                        <a href="{{ route('terms') }}" class="text-dark font-weight-bolder">
                                            {{ __('auth/register.terms_and_conditions') }}
                                        </a>
                                    </label>
                                    @error('terms')

                                        <p class='text-danger text-xs'>{{ $message }}</p>

                                    @enderror
                                </div>
                                <!-- Campo oculto para armazenar o token do reCAPTCHA -->
                                <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-50 my-4 mb-2">
                                        {{ __('auth/register.sign_up') }}
                                    </button>
                                </div>
                                <p class="text-sm mt-3 mb-0 col-xl-6 col-lg-5 col-md-6 mx-auto">
                                    {{ __('auth/register.already_have_account') }}
                                    <a href="{{ route('login') }}" class="text-dark font-weight-bolder">
                                        {{ __('auth/register.sign_in', ['login_link' => route('login')]) }}
                                    </a>
                                </p>
                                <br/><br/>
                            </form>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    grecaptcha.ready(function () {
                                        document.getElementById('registerForm').addEventListener('submit', function (event) {
                                            event.preventDefault(); // Impede o envio do formulário

                                            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'register'}).then(function (token) {
                                                document.getElementById('recaptchaResponse').value = token;
                                                event.target.submit(); // Envia o formulário após definir o token
                                            });
                                        });
                                    });
                                });
                                document.addEventListener('DOMContentLoaded', function () {
                                    const passwordInput = document.getElementById('password');
                                    const togglePassword = document.getElementById('togglePassword');
                                    const eyeIcon = document.getElementById('eyeIcon');

                                    passwordInput.addEventListener('focus', () => {
                                        togglePassword.style.display = 'inline-flex';
                                    });

                                    document.addEventListener('click', (e) => {
                                        if (!passwordInput.contains(e.target) && !togglePassword.contains(e.target)) {
                                            togglePassword.style.display = 'none';
                                        }
                                    });

                                    togglePassword.addEventListener('click', function () {
                                        const isPassword = passwordInput.type === 'password';
                                        passwordInput.type = isPassword ? 'text' : 'password';

                                        eyeIcon.classList.toggle('fa-eye');
                                        eyeIcon.classList.toggle('fa-eye-slash');
                                    });
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const passwordInput = document.getElementById('password');
                                        const strengthIndicator = document.getElementById('passwordStrength');

                                        passwordInput.addEventListener('input', function () {
                                            const val = passwordInput.value;
                                            let strength = 'Senha fraca';
                                            let color = 'text-danger';

                                            if (val.length >= 8 && /[A-Z]/.test(val) && /\d/.test(val) && /[^A-Za-z0-9]/.test(val)) {
                                                strength = 'Senha forte';
                                                color = 'text-success';
                                            } else if (val.length >= 6) {
                                                strength = 'Senha média';
                                                color = 'text-warning';
                                            }

                                            strengthIndicator.textContent = strength;
                                            strengthIndicator.className = 'text-xs ' + color;
                                        });    
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection

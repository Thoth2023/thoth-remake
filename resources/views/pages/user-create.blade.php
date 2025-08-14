@extends('layouts.app')

@section('content')
	@include('layouts.navbars.auth.topnav', ['title' => __('pages/profile.your_profile')])

	@push('styles')
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	@endpush

	<div class="container mt-7 mb-3">
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
								{{ __('pages/user-manager.singup_user')}}
								{{  (auth()->user()->occupation ? auth()->user()->occupation : '') }}
							</p>

						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- // Displays a user registration form with input fields for username, email, and password, including validation error messages -->
		<br>
		<div id="alert">
			@include('components.alert')
		</div>

		<div class="row" style="justify-content: space-around;">
			<div class="col-md-12">
				<div class="card">
					<form role="form" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
						@csrf

						<div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">
							<input type="text" name="username" class="form-control" style="margin-top: 3rem;"
								placeholder="{{ __('auth/register.username') }}"
								aria-label="{{ __('auth.register.username') }}" value="{{ old('username') }}">
							@error('username')
								<p class='text-danger text-xs pt-1'> {{ $message }} </p>
							@enderror
						</div>

						<div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">
							<input type="email" name="email" class="form-control"
								placeholder="{{ __('auth/register.email') }}" aria-label="{{ __('auth.register.email') }}"
								value="{{ old('email') }}">
							@error('email')
								<p class='text-danger text-xs pt-1'> {{ $message }} </p>
							@enderror
						</div>

						<!-- Campo de senha com botão de olho -->
						<div class="flex flex-col mb-3 col-xl-6 col-lg-5 col-md-6 mx-auto">
							<div class="input-group">
								<input type="password" name="password" id="password" class="form-control"
									placeholder="{{ __('auth/register.password') }}"
									aria-label="{{ __('auth.register.password') }}">
								<span class="input-group-text" onclick="togglePassword('password', 'eyeIcon')"
									style="cursor: pointer;">
									<i class="fas fa-eye" id="eyeIcon"></i>
								</span>
							</div>
							@error('password')
								<p class='text-danger text-xs pt-1'> {{ $message }} </p>
							@enderror
						</div>

						<div class="text-center">
							<button type="submit" class="btn bg-gradient-dark w-50 my-4 mb-2">
								{{ __('auth/register.sign_up') }}
							</button>
						</div>
						<br /><br />
					</form>
				</div>
			</div>
		</div>

		@include('layouts.footers.auth.footer')
	</div>

	@push('scripts')
		<script>
			function togglePassword(inputId, iconId) {
				const input = document.getElementById(inputId);
				const icon = document.getElementById(iconId);
				const isPassword = input.getAttribute("type") === "password";

				input.setAttribute("type", isPassword ? "text" : "password");
				icon.classList.toggle("fa-eye");
				icon.classList.toggle("fa-eye-slash");
			}
		</script>
	@endpush

@endsection

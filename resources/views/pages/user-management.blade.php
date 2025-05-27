@extends('layouts.app')

@section('content')
	<!-- Displays the user management table with options to add, edit, activate or deactivate users -->
	@include('layouts.navbars.auth.topnav', ['title' => __("nav/side.user_manager")])
	<div class="row mt-4 mx-4">
		<div class="col-12">
			<div class="card mb-4">
				<div class="card-header pb-0">
					<div class="d-flex justify-content-between align-items-center">
						<h6>{{ __("pages/user-manager.Users") }}</h6>
						<a href="{{ route('user.create') }}" class="btn btn-primary btn-sm"
							style="background-color:black;">{{ __("pages/user-manager.Add_User") }}</a>
					</div>
				</div>
				<div class="card-body px-0 pt-0 pb-2">
					<div class="table-responsive p-0">
						<table class="table align-items-center mb-0">
							<thead>
								<tr>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										{{ __("pages/user-manager.Name") }}
									</th>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
										{{ __("pages/user-manager.Role") }}
									</th>
									<th
										class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										{{ __("pages/user-manager.Institution") }}
									</th>
									<th
										class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										{{ __("pages/user-manager.Country") }}
									</th>
									<th
										class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										{{ __("pages/user-manager.Status") }}
									</th>
									<th
										class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										{{ __("pages/user-manager.Actions") }}
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $user)
									<tr>
										<td>
											<div class="d-flex px-3 py-1">
												<div class="d-flex flex-column justify-content-center">
													<h6 class="mb-0 text-sm">{{ $user->firstname }} {{ $user->lastname }}</h6>
												</div>
											</div>
										</td>
										<td>
											@if($user->role == 'SUPER_USER')
												<p class="text-sm font-weight-bold mb-0">{{ __('pages/user-manager.super_user') }}
												</p>
											@elseif($user->role == 'USER')
												<p class="text-sm font-weight-bold mb-0">{{ __('pages/user-manager.user') }}</p>
											@else
												<p class="text-sm font-weight-bold mb-0">{{ $user->role }}</p>
											@endif
										</td>
										<td class="align-middle text-center text-sm">
											<p class="text-sm font-weight-bold mb-0">{{ $user->institution }}</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="text-sm font-weight-bold mb-0">{{ $user->country }}</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="text-sm font-weight-bold mb-0">
												{{ $user->active ? __("pages/user-manager.Yes") : __("pages/user-manager.No") }}
										</td>
										</p>
										</td>
										<td class="align-middle text-end">
											<div class="d-flex px-3 py-1 justify-content-center align-items-center">
												<a href="{{ route('user.edit', ['user' => $user]) }}"
													class="btn btn-sm btn-primary me-2">
													{{ __("pages/user-manager.Edit") }}
												</a>
												@if ($user->active)
													<a href="{{ route('user.deactivate', ['user' => $user]) }}"
														class="btn btn-sm btn-danger">
														{{ __('pages/user-manager.Deactivate') }}
													</a>
												@else
													<a href="{{ route('user.deactivate', ['user' => $user]) }}"
														class="btn btn-sm btn-success">
														{{ __('pages/user-manager.Activate') }}
													</a>
												@endif

											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
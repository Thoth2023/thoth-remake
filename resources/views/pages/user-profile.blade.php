@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => __('pages/profile.your_profile')])

<div class="container mt-1 mb-3">

    <div class="page-header d-flex flex-column border-radius-lg">
        <div
            class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 "
            style="width: 100%"
        >
            <div class="text-center mx-auto">
                <h1 class="text-white">
                    {{ __("pages/profile.title-page") }}
                </h1>
                <p class="text-lead text-white">
                    {!!   __("pages/profile.description-page") !!}
                </p>
            </div>
        </div>
    </div>

	<!-- Displays user avatar with initials and basic profile info-->
    <div class="card shadow-lg mt-2">
        <div class="card-body">
            <div class="row gx-4">
                <div class="col-auto my-auto">
                    <div class="avatar avatar-xl rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; font-size: 1.5rem;">
                        {{ strtoupper(substr(auth()->user()->firstname, 0, 1)) }}{{ strtoupper(substr(auth()->user()->lastname, 0, 1)) }}
                    </div>
                </div>
                <div class="col my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                        </h5>
                        <span class="font-weight-bold text-sm mb-0">
                            {{ auth()->user()->institution ? auth()->user()->institution : 'Institution' }}
                        </span> :: <span class="mb-0 font-weight-bold text-sm">
                            {{ auth()->user()->occupation ? auth()->user()->occupation : 'Occupation' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- Displays the user profile edit form with personal, contact, and professional information -->
    <br>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="row" style="justify-content: space-around;">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0">{{ __('pages/profile.edit_profile') }}</p>
                                <div class="d-flex gap-2 ms-auto">
                                <button type="button" id="btn-editar" class="btn btn-primary btn-sm">
                                    Editar
                                </button>

                                <button type="button" class="btn btn-danger btn-sm" onclick="requestDataDeletion()">
                                    <i class="fas fa-trash"></i>  {{ __('pages/profile.request_data_deletion') }}
                                </button>
                            </div>
                        </div>
                    </div>
                <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <p class="text-uppercase text-sm">{{ __('pages/profile.user_information') }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.username') }}</label>
                                    <input class="form-control" type="text" name="username" value="{{ old('username', auth()->user()->username) }}"disabled>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.email') }}</label>
                                    <input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}"disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.first_name') }}</label>
                                    <input class="form-control" type="text" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}"disabled>
                                        @error('firstname')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.last_name') }}</label>
                                    <input class="form-control" type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}"disabled>
                                        @error('lastname')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">{{ __('pages/profile.contact_information') }}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address" class="form-control-label">{{ __('pages/profile.address') }}</label>
                                    <input id="autocomplete" class="form-control" type="text" name="address" value="{{ old('address', auth()->user()->address) }}"disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.city') }}</label>
                                    <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}"disabled>
                                        @error('city')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.country') }}</label>
                                    <input class="form-control" type="text" name="country" value="{{ old('country', auth()->user()->country) }}"disabled>
                                        @error('country')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.postal_code') }}</label>
                                    <input class="form-control" type="text" name="postal" value="{{ old('postal', auth()->user()->postal) }}"disabled>
                                        @error('postal')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">{{ __('pages/profile.about_me') }}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.about_me') }}</label>
                                    <input class="form-control" type="text" name="about" value="{{ old('about', auth()->user()->about) }}"disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.occupation') }}</label>
                                    <input class="form-control" type="text" name="occupation" value="{{ old('occupation', auth()->user()->occupation) }}"disabled>
                                        @error('occupation')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.institution') }}</label>
                                    <input class="form-control" type="text" name="institution" value="{{ old('institution', auth()->user()->institution) }}"disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">{{ __('pages/profile.lattes_link') }}</label>
                                    <input class="form-control" type="text" id="lattes_link" name="lattes_link" value="{{ old('lattes_link', auth()->user()->lattes_link) }}"disabled>
                                    @error("lattes_link")
                                        <span class="text-xs text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <br/>
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="btn-salvar" class="btn btn-success btn-sm" style="display: none;">
                                    <i class="fas fa-save"></i>  {{ __('pages/profile.save') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="dataDeletionConfirmationModal" tabindex="-1" aria-labelledby="dataDeletionConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataDeletionConfirmationModalLabel">{{ __('pages/profile.confirmation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('pages/profile.confirmation_message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Handles user data deletion request with confirmation and modal display -->
@push('js')
    <script id="requestDataDeletionScript">
        if (!window.requestDataDeletionLoaded) {
            window.requestDataDeletionLoaded = true;

            function requestDataDeletion() {
                if (confirm('{{ __("pages/profile.confirm-exclusion") }}')) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                    fetch("{{ route('user.requestDataDeletion') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({})
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'success') {
                                const modalElement = document.getElementById('dataDeletionConfirmationModal');
                                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                                if (modalInstance) {
                                    modalInstance.dispose();
                                }

                                const dataDeletionConfirmationModal = new bootstrap.Modal(modalElement, {
                                    backdrop: 'static',
                                    keyboard: false
                                });
                                dataDeletionConfirmationModal.show();
                            }
                        })
                        .catch(error => console.error('Erro:', error));
                } else {
                    console.log('A exclusão foi cancelada pelo usuário.');
                }
            }
        }

        document.getElementById('btn-editar').addEventListener('click', function () {
            document.querySelectorAll('form input, form select, form textarea').forEach(el => {
                el.removeAttribute('disabled');
            });
            const btnSalvar = document.getElementById('btn-salvar');
            if (btnSalvar) {
                btnSalvar.style.display = 'inline-block';
            }
            this.disabled = true;
        });


    </script>
@endpush

@push('js')
    <script>
        window.onload = function () {
            console.log('Página carregada: Perfil do Usuário');
        };
    </script>
@endpush

@endsection

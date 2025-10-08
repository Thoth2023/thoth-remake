@extends('layouts.app')

@section('content')

    @include('layouts.navbars.auth.topnav', ['title' => __("nav/side.user_manager")])
    <style>
        /* ---------- Estilos de melhoria visual ---------- */
        .table-wrapper {
            border-radius: 12px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .table td, .table th {
            vertical-align: middle;
            padding: 0.9rem 1rem;
        }

        .table td h6 {
            font-weight: 600;
            margin-bottom: 0;
        }

        .btn-action {
            min-width: 90px;
            border-radius: 6px;
        }

        .table-responsive {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Scroll suave dentro da div */
        .table-responsive::-webkit-scrollbar {
            width: 6px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .card-header h6 {
            font-weight: 700;
            margin-bottom: 0;
        }
    </style>
    <div class="container mt-4 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-2 border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 "
                style="width: 100%"
            >
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white" style="font-size: 2rem">
                        {{ __("pages/user-manager.Users") }}
                    </h1>

                    <p class="text-lead text-white">
                        {{ __("pages/user-manager.description") }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-1 mx-4">
        <div class="col-12">
            <div class="card mb-4 table-wrapper">
                <div class="card-header d-flex justify-content-between align-items-center pb-3">
                    <h5>{{ __("pages/user-manager.Users") }}</h5>
                    <a href="{{ route('user.create') }}" class="btn btn-dark btn-sm">
                        <i class="fas fa-user-plus me-1"></i> {{ __("pages/user-manager.Add_User") }}
                    </a>
                </div>

                <div class="card-body px-0 pt-0 pb-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0">
                            <thead >
                            <tr>
                                <th>{{ __("pages/user-manager.Name") }}</th>
                                <th>{{ __("pages/user-manager.Role") }}</th>
                                <th>{{ __("pages/user-manager.Institution") }}</th>
                                <th>{{ __("pages/user-manager.Country") }}</th>
                                <th>{{ __("pages/user-manager.Status") }}</th>
                                <th class="text-center">{{ __("pages/user-manager.Actions") }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <h6>{{ $user->firstname }} {{ $user->lastname }}</h6>
                                    </td>
                                    <td>
                                        @if($user->role == 'SUPER_USER')
                                            <span class="badge bg-dark">{{ __('pages/user-manager.super_user') }}</span>
                                        @elseif($user->role == 'USER')
                                            <span class="badge bg-secondary">{{ __('pages/user-manager.user') }}</span>
                                        @else
                                            <span class="badge bg-info text-dark">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span>{{ $user->institution }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span>{{ $user->country }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($user->active)
                                            <span class="badge bg-success">{{ __("pages/user-manager.Yes") }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __("pages/user-manager.No") }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('user.edit', ['user' => $user]) }}" class="btn btn-sm btn-outline-primary btn-action">
                                                <i class="fas fa-edit me-1"></i> {{ __("pages/user-manager.Edit") }}
                                            </a>
                                            @if ($user->active)
                                                <a href="{{ route('user.deactivate', ['user' => $user]) }}" class="btn btn-sm btn-outline-danger btn-action">
                                                    <i class="fas fa-user-slash me-1"></i> {{ __('pages/user-manager.Deactivate') }}
                                                </a>
                                            @else
                                                <a href="{{ route('user.deactivate', ['user' => $user]) }}" class="btn btn-sm btn-outline-success btn-action">
                                                    <i class="fas fa-user-check me-1"></i> {{ __('pages/user-manager.Activate') }}
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

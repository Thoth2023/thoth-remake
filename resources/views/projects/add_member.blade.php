@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __('pages/add_member.add_member')])

    <style>
        /* Renomeado para clareza e removido o "2" */
        .level-select-small {
            width: 130px; /* Ajuste para caber melhor na coluna da tabela */
        }

        /* Ajuste do botão de ajuda para melhor alinhamento com o label */
        .help-thoth-button {
            margin-left: 5px;
            font-size: 1.0rem; /* Botão menor */
            line-height: 1;
            padding: 0.8em 0.6em;
            border-radius: 10%;
        }

        /* Ajuste para alinhar o badge de status verticalmente no centro da linha */
        .status-cell-container {
            display: flex;
            align-items: center;
            /* Removendo min-height: 40px; e usando height: 100% */
            height: 100%;
            padding-left: 0.5rem;
        }

        /* NOVO: Classe para alinhar o formulário de atualização do nível na tabela */
        .member-level-actions {
            display: flex;
            align-items: center; /* Alinha o select e o botão verticalmente */
            height: 100%; /* Garante que o flex ocupe a altura total da célula */
        }

        /* NOVO: Classe para alinhar verticalmente o conteúdo de células que contém botões/formulários */
        .table-action-cell {
            vertical-align: middle !important; /* Alinha o conteúdo da célula verticalmente */
            /* Garante uma altura mínima consistente para o alinhamento funcionar */
            height: 60px;
            /* ADICIONADO: Normaliza o padding vertical e horizontal das células para melhor alinhamento visual */
            padding: 0.75rem 0.5rem;
        }

        /* Regra para garantir que as células que contêm dados de texto simples também tenham o padding ajustado */
        .table > tbody > tr > td {
            /* Força o padding da célula, garantindo espaço para os elementos de ação */
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }

        /* Removendo CSS redundante */
        .table-responsive table {
            width: 100%;
            max-width: 100%;
        }
    </style>

    <div class="card shadow-lg mx-4 mt-5">
        @include('components.alert')

        <div class="container-fluid py-4 px-4">

            <div class="card-header pb-0 mt-0 mb-5 d-flex justify-content-between align-items-center">
                <h5 class="card-header p-0 ">{{__('pages/add_member.add_member')}}</h5>

                <x-helpers.modal
                    target="permissions-modal"
                    modalTitle=""
                    modalContent="{!! __('project/permissions.modal.content') !!}"
                    textClose="{{ __('project/permissions.modal.close') }}"
                >
                    <x-slot:trigger>
                                <span class="ms-2" data-bs-toggle="tooltip" title="{{ __('project/permissions.modal.title') }}">
                                    <i class="fas fa-question-circle text-primary" style="cursor:pointer; font-size:18px;"></i>
                                </span>
                    </x-slot:trigger>
                </x-helpers.modal>

            </div>

            <form method="POST" action="{{ route('projects.add_member', $project->id_project) }}">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <div class="d-flex align-items-center mb-1">
                        <label for="emailMemberInput" class="form-label mb-0">{{__('pages/add_member.email_label')}}</label>
                        <button type="button" class="btn bg-gradient-warning p-0 help-thoth-button" data-bs-toggle="modal"
                                data-bs-target="#modal-notification">?</button>
                    </div>

                    <input name="email_member" type="text"
                           class="form-control @error('email_member') is-invalid @enderror" id="emailMemberInput"
                           placeholder="{{__('pages/add_member.enter_email')}}">
                    @error('email_member')
                    <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <div class="d-flex align-items-center mb-1">
                        <label for="levelMemberSelect" class="form-label mb-0">{{__('pages/add_member.level')}}</label>
                        <button type="button" class="btn bg-gradient-warning p-0 help-thoth-button" data-bs-toggle="modal"
                                data-bs-target="#modal-notification-2">?</button>
                    </div>

                    <select class="form-select" id="levelMemberSelect" name="level_member">
                        <option value="" disabled selected>{{__('pages/add_member.level_select')}}</option>
                        <option value=2>{{__('pages/add_member.viewer')}}</option>
                        <option value=3>{{__('pages/add_member.researcher')}}</option>
                        <option value=4>{{__('pages/add_member.reviser')}}</option>
                    </select>
                </div>

                <div class="d-flex">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary me-2">
                        {{__('pages/add_member.cancel_button')}}
                    </a>
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check me-1"></i> {{__('pages/add_member.add')}}</button>
                </div>
            </form>

            <hr class="horizontal dark mt-4">

            <h5 class="mb-3">{{__('pages/add_member.current_members')}}</h5>
        </div>



        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('pages/add_member.name')}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('pages/add_member.email')}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('pages/add_member.level')}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('pages/add_member.status')}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2 action-col">
                        {{__('pages/add_member.delete')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users_relation as $member)
                    <tr>
                        <td class="table-action-cell">
                            <div class="d-flex px-2 py-1">
                                <div class="my-auto">
                                    <h6 class="mb-0 text-sm">{{ $member->username }}</h6>
                                </div>
                            </div>
                        </td>
                        <td class="table-action-cell">
                            <p class="text-sm font-weight-bold mb-0">{{ $member->email }}</p>
                        </td>

                        @if ($member->pivot->level == 1)
                            <td class="table-action-cell">
                                <p class="text-sm font-weight-bold mb-0">{{__('pages/add_member.admin')}}</p>
                            </td>
                            <td >
                                <div >
                                    <span class="badge bg-primary">{{__('pages/add_member.status_owner')}}</span>
                                </div>
                            </td>
                            <td class="table-action-cell"></td>
                        @else
                            <td class="table-action-cell">
                                <form class="member-level-actions"
                                      action="{{ route('projects.update_member_level', ['idProject' => $project->id_project, 'idMember' => $member->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')

                                    <select class="form-select level-select-small me-2" name="level_member" required>
                                        <option value="2"
                                            {{ $member->level_name == 'Viewer' ? 'selected' : '' }}>{{__('pages/add_member.viewer')}}
                                        </option>
                                        <option value="3"
                                            {{ $member->level_name == 'Researcher' ? 'selected' : '' }}>
                                            {{__('pages/add_member.researcher')}}</option>
                                        <option value="4"
                                            {{ $member->level_name == 'Reviser' ? 'selected' : '' }}>{{__('pages/add_member.reviser')}}
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-outline-success"
                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="{{__('pages/add_member.confirm_level_tooltip')}}">
                                        <i class="fa fa-check me-1"></i> {{__('pages/add_member.confirm')}}
                                    </button>
                                </form>
                            </td>

                            <td class="table-action-cell">
                                @php
                                    $status = $member->pivot->status ?? null;
                                    $statusText = __('pages/add_member.status_accepted');
                                    $statusClass = 'bg-success';

                                    if ($status === 'pending') {
                                        $statusText = __('pages/add_member.status_pending');
                                        $statusClass = 'bg-warning';
                                    } elseif ($status === 'declined') {
                                        $statusText = __('pages/add_member.status_declined');
                                        $statusClass = 'bg-danger';
                                    }
                                @endphp

                                <div class="d-flex align-items-center gap-2">

                                    {{-- Badge de Status --}}
                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>

                                    {{-- Ícone para reenviar convite se pendente --}}
                                    @if($status === 'pending')
                                        <form action="{{ route('projects.resend_invitation', [
                                                            'idProject' => $project->id_project,
                                                            'idMember' => $member->id
                                                        ]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-link p-0 m-0 text-info"
                                                    data-bs-toggle="tooltip"
                                                    title="{{ __('pages/add_member.resend_invite') }}">
                                                <i class="fa-regular fa-envelope"></i>
                                            </button>
                                        </form>

                                    @endif

                                </div>
                            </td>


                            <td class="text-center">
                                <button type="button" class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-delete-{{ $member->id }}">
                                    <i class="fa fa-trash-alt me-1"></i> {{__('pages/add_member.delete')}}
                                </button>

                                <div class="modal fade" id="modal-delete-{{ $member->id }}" tabindex="-1"
                                     role="dialog" aria-labelledby="modal-delete-{{ $member->id }}"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title"
                                                    id="modal-title-delete-{{ $member->id }}">{{__('pages/add_member.modal_confirm_deletion_title')}}</h6>
                                                <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{__('pages/add_member.modal_confirm_deletion_body')}}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form
                                                    action="{{ route('projects.destroy_member', ['idProject' => $project->id_project, 'idMember' => $member->id]) }}"
                                                    method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-danger">{{__('pages/add_member.delete')}}</button>
                                                </form>
                                                <button type="button" class="btn btn-link ms-auto"
                                                        data-bs-dismiss="modal">{{__('pages/add_member.cancel_button')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection


<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog"
     aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-notification">{{__('pages/add_member.instruction_email')}}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="py-3">
                    <h5 class="text-sm mt-4"><i class="ni ni-single-copy-04"></i>
                        {{__('pages/add_member.user_registered')}}</h5>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">{{__('pages/add_member.got_it')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-notification-2" tabindex="-1" role="dialog"
     aria-labelledby="modal-notification-2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-notification">{{__('pages/add_member.instruction_level')}}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="py-3 text-center">
                    <h4 class="text-gradient text-danger mt-4"><i class="ni ni-single-copy-04"></i>
                        {{__('pages/add_member.instruction_level')}}</h4>
                    <ul class="text-start mx-4 list-unstyled">
                        <li class="mb-2"> <strong>{{__('pages/add_member.level_viewer')}}</strong>
                            <p class="text-sm mb-0">{{__('pages/add_member.level_viewer_description')}}</p>
                        </li>
                        <li class="mb-2"><strong>{{__('pages/add_member.level_researcher')}}</strong>
                            <p class="text-sm mb-0">{{__('pages/add_member.level_researcher_description')}}</p>
                        </li>
                        <li class="mb-2"><strong>{{__('pages/add_member.level_reviser')}}</strong>
                            <p class="text-sm mb-0">{{__('pages/add_member.level_reviser_description')}}</p>
                        </li>
                        <li><strong>{{__('pages/add_member.level_administrator')}}</strong>
                            <p class="text-sm mb-0">{{__('pages/add_member.level_administrator_description')}}</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">{{__('pages/add_member.got_it')}}</button>
            </div>
        </div>
    </div>
</div>

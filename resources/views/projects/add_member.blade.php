@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => __('pages/add_member.add_member')])
<style>
    .levelMemberSelect2 {
        width: 120px;
    }

    /* Add styles for table responsiveness */
    .table-responsive {
        overflow-x: auto;
    }

    .table-responsive table {
        width: 100%;
        max-width: 100%;
    }
</style>
<div class="card shadow-lg mx-4">
    @include('components.alert')
    <div class="container-fluid py-4">
        <p class="card-header pb-0">
        <h5>{{__('pages/add_member.add_member')}}</h5>
        </p>
        <form method="POST" action="{{ route('projects.add_member', $project->id_project) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="emailMemberInput">Email</label>
                <button type="button" class="bg-gradient-warning mb-3 help-thoth-button" data-bs-toggle="modal"
                    data-bs-target="#modal-notification">?</button>
                <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog"
                    aria-labelledby="modal-notification" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-notification">{{__('pages/add_member.instruction_email')}}
                                </h6>
                                <button type="button" class="btn btn-danger small-button" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="py-3 text-center">
                                    <h4 class="text-gradient text-danger mt-4"><i class="ni ni-single-copy-04"></i>
                                        {{__('pages/add_member.user_registered')}}
                                    </h4>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">{{__('pages/add_member.got_it')}}</button>
                            </div>
                        </div>
                    </div>
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
            <div class="form-group">
                <label for="levelMemberSelect">{{__('pages/add_member.level')}}</label>
                <button type="button" class="bg-gradient-warning mb-3 help-thoth-button" data-bs-toggle="modal"
                    data-bs-target="#modal-notification-2">?</button>
                <div class="modal fade" id="modal-notification-2" tabindex="-1" role="dialog"
                    aria-labelledby="modal-notification-2" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-notification">{{__('pages/add_member.instruction_level')}}</h6>
                                <button type="button" class="btn btn-danger small-button" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="py-3 text-center">
                                    <h4 class="text-gradient text-danger mt-4"><i class="ni ni-single-copy-04"></i>
                                        {{__('pages/add_member.select_level')}}
                                    </h4>
                                    <p>
                                        <strong>{{__('pages/add_member.level_administrator')}} </strong>{{__('pages/add_member.level_administrator_description')}}<br />
                                        <strong>{{__('pages/add_member.level_viewer')}}</strong>{{__('pages/add_member.level_viewer_description')}}<br />
                                        <strong>{{__('pages/add_member.level_researcher')}} </strong>{{__('pages/add_member.level_researcher_description')}}<br />
                                        <strong>{{__('pages/add_member.level_reviser')}} </strong>{{__('pages/add_member.level_reviser_description')}}<br />
                                    <p></p>
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">{{__('pages/add_member.got_it')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <select class="form-select" id="levelMemberSelect" name="level_member">
                    <option value="" disabled selected>{{__('pages/add_member.level_select')}}</option>
                    <option value=2>{{__('pages/add_member.viewer')}}</option>
                    <option value=3>{{__('pages/add_member.researcher')}}</option>
                    <option value=4>{{__('pages/add_member.reviser')}}</option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-primary ms-auto" name="add">
                    {{ __('pages/add_member.add') }}
                </button>

                {{--
                     * Adicionado o tooltip utilizado no menu de projetos,
                    * para que o usuário consiga, de forma rápida,
                    * abrir o projeto após gerenciar os membros do mesmo.
                --}}
                <a
                    class="btn btn-primary ms-auto"
                    data-bs-toggle="tooltip"
                    href="{{ route('projects.show', $project->id_project) }}">
                    <i class="fas fa-search-plus"></i> {{ __('project/projects.project.options.open_project') }}
                </a>
            </div>

        </form>

        <table class="table align-items-center justify-content-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        {{__('pages/add_member.name')}}
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('pages/add_member.level')}}
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                        {{__('pages/add_member.delete')}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users_relation as $member)
                <tr>
                    <td>
                        <div class="d-flex px-2">
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm">{{ $member->username }}</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $member->email }}</p>
                    </td>
                    @if ($member->pivot->level == 1)
                    <td>
                        <p class="text-sm font-weight-bold mb-0">{{__('pages/add_member.admin')}}</p>
                    </td>
                    <td></td>
                    @else
                    <td>
                        <form class="update-member-level-form selectpicker"
                            action="{{ route('projects.update_member_level', ['idProject' => $project->id_project, 'idMember' => $member->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-auto">
                                    <select class="form-select levelMemberSelect2" name="level_member" required>
                                        <option value="2"
                                            {{ $member->level_name == 'Viewer' ? 'selected' : '' }}>Viewer
                                        </option>
                                        <option value="3"
                                            {{ $member->level_name == 'Researcher' ? 'selected' : '' }}>
                                            Researcher</option>
                                        <option value="4"
                                            {{ $member->level_name == 'Reviser' ? 'selected' : '' }}>Reviser
                                        </option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-success btn-sm ms-auto"
                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Confirm member level change">Confirm</button>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td class="text-center col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger btn-sm ms-auto mr-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-{{ $member->id }}">Delete</button>
                                <div class="modal fade" id="modal-delete-{{ $member->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modal-delete-{{ $member->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title"
                                                    id="modal-title-delete-{{ $member->id }}">Confirm
                                                    Deletion</h6>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this member?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form
                                                    action="{{ route('projects.destroy_member', ['idProject' => $project->id_project, 'idMember' => $member->id]) }}"
                                                    method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-danger">Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-link ml-auto"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
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
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Add Member'])
<div class="card shadow-lg mx-4">
    <div class="container-fluid py-4">
        <p class="card-header pb-0"><h5>Add Member</h5></p>
        <form method="POST" action="{{ route('projects.member_update', $project->id_project) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="titleInput">Email</label>
                <input name="email_member" value="{{ $project->email_member }}" type="text" class="form-control" id="emailMemberInput" placeholder="Enter the email">
            </div>
            <div class="form-group">
                <label for="levelCollaboratorSelect">Level</label>
                <select class="form-control" id="levelCollaboratorSelect" name="level_member">
                    <option value = 1>Viewer</option>
                    <option value = 2>Researcher</option>
                    <option value = 3>Reviser</option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-primary btn ms-auto" name="add">Add</button>
            </div>
        </form>          
        @include('layouts.footers.auth.footer')
    </div>
</div>
@endsection





{{-- <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Level</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                        Delete</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projects as $project)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2">
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">{{ $members->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $members->email }}</p>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">{{$members->level}}</span> // ver depois como responde inteiro para string
                                    </td>
                                    <!-- <td class="align-middle text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="me-2 text-xs font-weight-bold">100%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td> -->
                                    <td class="align-middle">
                                        <a href="{{ route('projects.edit', $project->id_project) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                            Edit
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <a onclick="event.preventDefault(); document.getElementById('delete-project-{{ $project->id }}').submit();" href="#" class="font-weight-bold text-xs btn btn-link text-danger text-gradient px-3 mb-0" data-toggle="tooltip" data-original-title="Edit user">
                                            Delete
                                        </a>
                                        <form id="delete-project-{{ $project->id }}" action="{{ route('projects.destroy', $project) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                    <!-- <td class="align-middle">
                                        <a  href="{{route('projects.add', $project->id_project)}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Add member">
                                            Add Member
                                        </a>
                                        <form id="delete-project-{{ $project->id }}" action="{{}}" method="POST" style="display: none;">
                                            @csrf
                                            
                                        </form>
                                    </td> -->
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No projects found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}



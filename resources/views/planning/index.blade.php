@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planning Overall Information'])
<div class="container-fluid py-4">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Planning</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tabs-simple" role="tab" aria-controls="profile" aria-selected="true">
                                Domain
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard" aria-selected="false">
                                Dashboard
                                </a>
                            </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row" style="justify-content: space-around;">
                        <div class="col-md-8">
                            <div class="card">
                                <form role="form" method="POST" action={{ route('planning_overall.domainUpdate') }} enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-header pb-0">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0">Domains</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-text-input" class="form-control-label">Description</label>
                                                    <input class="form-control" type="text" name="description">
                                                    <input clas="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                                                   
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                            </div>
                                            <div class="table-responsive p-0">
                                                <table class="table align-items-center justify-content-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Description
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($domains as $domain)
                                                        <tr>
                                                            <td>
                                                                <p class="text-sm font-weight-bold mb-0">{{ $domain->description }}</p>
                                                            </td>
                                                            <td class="align-middle">
                                                                <a class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit domain">
                                                                    Edit
                                                                </a>
                                                                <!-- Modal Here Edition -->
                                                            </td>
                                                            <td class="align-middle">
                                                                <form action="{{ route('planning_overall.domainDestroy', $domain->id_domain) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete domain">Delete</button>
                                                                </form>
                                                            </td> 
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No domains found.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <hr class="horizontal dark">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection

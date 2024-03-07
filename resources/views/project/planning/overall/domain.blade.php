<div class="card-group card-frame mt-5">
    <div class="card">
        <form role="form" method="POST" action="{{ route('project.planning_overall.domainUpdate') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">Domains</p>
                        @include ('components.help-button', ['dataTarget' => 'DomainModal'])
                        <!-- Help Button Description -->
                        @include(
                        'components.help-modal',
                        [
                            'modalId' => 'DomainModal',
                            'modalLabel' => 'exampleModalLabel',
                            'modalTitle' => 'Help for Domains',
                            'modalContent' => 'test'
                            ]
                        )
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Description</label>
                                <input class="form-control" type="text" name="description">
                                <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
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
                                <button style="border:0; background: none; padding: 0px;" type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-form{{ $domain->id_domain }}" data-original-title="Edit domain">Edit</button>
                                <!-- Modal for Editing -->
                                <div class="col-md-4">
                                    <div class="modal fade" id="modal-form{{ $domain->id_domain }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="card card-plain">
                                                        <div class="card-header pb-0 text-left">
                                                            <h3>Domain Update</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <form role="form text-left" method="POST" action="{{ route('project.planning_overall.domainEdit', $domain->id_domain) }}">
                                                                @csrf
                                                                @method('POST')
                                                                <label>Domain</label>
                                                                <div class="input-group mb-3">
                                                                    <input class="form-control" type="text" name="description" value="{{ $domain->description }}">
                                                                </div>
                                                                <div class="text-center">
                                                                    <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Ends Here -->
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('project.planning_overall.domainDestroy', $domain->id_domain) }}" method="POST">
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
            <hr class="horizontal dark">
        </form>
    </div>
</div>

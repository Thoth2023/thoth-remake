@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => __("nav/side.add_permission")])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{__("superuser/levels.add_permission")}}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="p-3">
                    <form action="{{ route('levels.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="level" class="form-label">{{__("superuser/levels.profile_name")}}</label>
                            <input type="text" class="form-control" id="level" name="level" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{__("superuser/levels.profile_description")}}</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <label>{{__("superuser/levels.system_permissions")}}</label>
                                <select multiple id="available-permissions" class="form-control" size="10">
                                    <option value="1">admin.users.add</option>
                                    <option value="2">admin.users.view</option>
                                    <option value="3">admin.users.edit</option>
                                    <option value="4">admin.users.delete</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                                <div class="button-group">
                                    <button type="button" id="btn-add" class="btn btn-primary mb-2"><i class="fas fa-arrow-right"></i></button>
                                    <button type="button" id="btn-remove" class="btn btn-primary"><i class="fas fa-arrow-left"></i></button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label>{{__("superuser/levels.group_permissions")}}</label>
                                <select multiple id="assigned-permissions" name="permissions[]" class="form-control" size="10">
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">{{__("superuser/levels.save")}}</button>
                        <a href="{{ route('levels.index') }}" class="btn btn-secondary">{{__("superuser/levels.cancel")}}</a>
                    </form>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('btn-add').addEventListener('click', function() {
        moveOptions(document.getElementById('available-permissions'), document.getElementById('assigned-permissions'));
    });

    document.getElementById('btn-remove').addEventListener('click', function() {
        moveOptions(document.getElementById('assigned-permissions'), document.getElementById('available-permissions'));
    });

    function moveOptions(from, to) {
        let selectedOptions = Array.from(from.selectedOptions);
        selectedOptions.forEach(option => {
            to.appendChild(option);
        });
    }
</script>
@endsection

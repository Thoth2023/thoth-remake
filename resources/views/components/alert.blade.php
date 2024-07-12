<div class="px-4 pt-4">
    @if ($message = session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text">{{ session()->get('sucess') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($message = session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-text">{{ session()->get('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->has('level_member'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-text">{{ $errors->first('level_member') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
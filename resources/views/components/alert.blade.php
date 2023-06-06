<div class="px-4 pt-4">
    @if ($message = session()->has('succes'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p class="text-white mb-0">{{ session()->get('succes') }}</p>
        </div>
    @endif
    @if ($message = session()->has('error'))
        <div class="alert alert-danger" role="alert">
            <p class="text-white mb-0">{{ session()->get('error') }}</p>
        </div>
    @endif
    @if ($errors->has('level_member'))
        <div class="alert alert-danger">
            <p>{{ $errors->first('level_member') }}</p>
        </div>
    @endif
</div>

<script>
    setTimeout(function() {
        var successAlert = document.querySelector('.alert-success');
        var errorAlert = document.querySelector('.alert-danger');
        
        if (successAlert) {
            successAlert.remove();
        }
        
        if (errorAlert) {
            errorAlert.remove();
        }
    }, 2000);
</script>

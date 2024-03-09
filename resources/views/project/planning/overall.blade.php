<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-group justify-content-center">
            <!-- Domain Section starts here -->
            @include('project.planning.overall.domain')
            <!-- Domain Section ends here -->

            <!-- Language Section starts here -->
            @include('project.planning.overall.language')
            <!-- Language Section ends here -->

            <!-- Study Type Section starts here -->
            @include('project.planning.overall.study-type')
            <!-- Study Type Section ends here -->

            <!-- Keywords Section starts here -->
            @include('project.planning.overall.keywords')
            <!-- Keywords Section ends here -->

            <!-- Date Section starts here -->
            @include('project.planning.overall.dates')
            <!-- Date Section ends here -->

        </div>
    </div>
</div>


<div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Bootstrap</strong>
            <small class="toast-time"></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastContainer = document.querySelector('.toast-container');
            const toastElement = toastContainer.querySelector('.toast');
            const toastBody = toastElement.querySelector('.toast-body');
            const toastTime = toastElement.querySelector('.toast-time');

            function showToast(message, type) {
                toastBody.innerText = message;
                toastElement.querySelector('.toast-header strong').innerText = type;
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            }

            // Check if there's an error or success flash message
            const errorMessage = "{{ session('error') }}";
            const successMessage = "{{ session('success') }}";

            if (errorMessage) {
                showToast(errorMessage, 'Error');
            } else if (successMessage) {
                showToast(successMessage, 'Success');
            }
        });
    </script>
@endpush

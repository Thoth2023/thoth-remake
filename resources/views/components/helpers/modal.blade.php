@props([
    "target" => "modal",
    "modalTitle",
    "modalContent",

])

<?php $randomId = rand(); ?>

<div class="d-flex align-items-center justify-content-between">
    <p class="mb-0 text-lg text-bold">{{ $modalTitle }}</p>

    <button
        type="button"
        class="btn btn-primary rounded-circle p-0 m-0"
        data-bs-toggle="modal"
        data-bs-target="#{{ $target }}-{{ $randomId }}"
        style="width: 2em; height: 2em; font-size: 1rem"
    >
        ?
    </button>

    <div
        class="modal fade"
        id="{{ $target }}-{{ $randomId }}"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $modalTitle }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <span class="text-secondary text-lg" aria-hidden="true">
                            <i class="fa fa-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! $modalContent !!}

                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn bg-gradient-primary"
                        data-bs-dismiss="modal"
                    >
                        {{ translationPlanning("button.close") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

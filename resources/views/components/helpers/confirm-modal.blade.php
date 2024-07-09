@props([
    "target" => "modal",
    "modalTitle",
    "modalContent",
    "onConfirm" => "() => {}",
    "onConfirmNativeClick" => "() => {}",
    "textClose" => "Close",
    "textConfirm" => "Confirm",
    "typeConfirmButton" => "button",
])

<?php $randomId = rand(); ?>

<div class="d-flex align-items-center justify-content-between">
    <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#{{ $target }}-{{ $randomId }}"
        {{ $attributes->merge(["class" => "btn"]) }}
    >
        {{ $slot }}
    </button>

    <div
        class="modal fade"
        id="{{ $target }}-{{ $randomId }}"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                <div class="modal-body text-wrap">
                    {!! $modalContent !!}
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn text-white bg-secondary"
                        data-bs-dismiss="modal"
                    >
                        {{ $textClose }}
                    </button>
                    <button
                        type="{{ $typeConfirmButton }}"
                        class="btn text-white bg-danger"
                        data-bs-dismiss="modal"
                        wire:click="{{ $onConfirm }}"
                        onclick="{{ $onConfirmNativeClick }}"
                    >
                        {{ $textConfirm }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- resources/views/message.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-3 mb-3">

        <div class="page-header d-flex flex-column border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 "
                style="width: 100%"
            >
            <h3 class="text-white">{{ translationProfile('message_heading') }}</h3>
            <span class="text-lead text-white">{{ translationProfile('exclusion-success') }}</span><br/>
            <span class="text-lead text-white">
                {{ translationProfile('redirect_notice') }} <b><span id="countdown" class="text-primary">15</span> {{ __('seconds') }}.</b>
            </span>
        </div>
    </div>
    </div>

    <script>
        let countdown = 15;
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown === 0) {
                clearInterval(interval);

                // Realizar o logout e redirecionar
                fetch("{{ route('logout') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    }
                }).then(() => {
                    window.location.href = "{{ route('home') }}";
                });
            }
        }, 1000);
    </script>
@endsection

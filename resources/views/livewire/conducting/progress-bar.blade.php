<!-- resources/views/livewire/conducting/progress-bar.blade.php -->
<div>
    <div class="progress" style="height: 30px; background-color: #f3f3f3; border-radius: 15px; overflow: hidden; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);">
        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%; background-color: {{ $progress >= 75 ? '#4caf50' : ($progress >= 50 ? '#ff9800' : '#f44336') }}; border-radius: 15px; box-shadow: 0 3px 3px -5px rgba(0, 0, 0, 0.1), 0 2px 5px {{ $progress >= 75 ? '#4caf50' : ($progress >= 50 ? '#ff9800' : '#f44336') }};" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
            <span style="color: #fff; font-weight: bold; font-size: 14px;">Progress Quality Assessment: {{ $progress }}%</span>
        </div>
    </div>
</div>

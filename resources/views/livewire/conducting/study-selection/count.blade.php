@if (session()->has('error'))
    <div class='card card-body col-md-12 mt-3'>
        <h3 class="h4 mb-3">Complete these tasks to advance</h3>
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    </div>
@else
<div>
    <div class="progress mb-4" style="height: 10px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $acceptedPercentage }}%;" aria-valuenow="{{ $acceptedPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($acceptedPercentage, 2) }}%</div>
        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $rejectedPercentage }}%;" aria-valuenow="{{ $rejectedPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($rejectedPercentage, 2) }}%</div>
        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $unclassifiedPercentage }}%;" aria-valuenow="{{ $unclassifiedPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($unclassifiedPercentage, 2) }}%</div>
        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $duplicatePercentage }}%;" aria-valuenow="{{ $duplicatePercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($duplicatePercentage, 2) }}%</div>
        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $removedPercentage }}%;" aria-valuenow="{{ $removedPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($removedPercentage, 2) }}%</div>
    </div>

    <div class="d-flex gap-4 mb-3">
        <div class="text-success">Accepted: {{ count($accepted) }}</div>
        <div class="text-danger">Rejected: {{ count($rejected) }}</div>
        <div class="text-warning">Unclassified: {{ count($unclassified) }}</div>
        <div class="text-info">Duplicate: {{ count($duplicates) }}</div>
        <div class="text-secondary">Removed: {{ count($removed) }}</div>
        <div>Total: {{ count($papers) }}</div>
    </div>
</div>
@endif

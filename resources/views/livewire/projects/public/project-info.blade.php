<div class="small">
    <div class="card border shadow-sm p-3">
        <div class="row">

            {{-- Título --}}
            <div class="col-12 mb-2">
                <h6 class="text-uppercase">
                    <span class="text-wrap text-break d-block">{{ $project->title }}</span>
                </h6>
            </div>

            {{-- Descrição --}}
            <div class="col-12 mb-2">
                <strong>{{ __('project/public_protocol.description') }}:</strong><br>
                <span class="text-wrap text-break d-block">{{ $project->description }}</span>
            </div>

            {{-- Objetivos --}}
            <div class="col-12">
                <strong>{{ __('project/public_protocol.objectives') }}:</strong><br>
                <span class="text-wrap text-break d-block">{{ $project->objectives }}</span>
            </div>

        </div>
    </div>
</div>

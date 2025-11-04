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
            {{-- Type --}}
            <div class="col-12">
                @php
                    $feature = is_array($project->feature_review)
                        ? ($project->feature_review[0] ?? '')
                        : $project->feature_review;
                @endphp
                <strong>{{ __('project/public_protocol.feature_review') }}:</strong><br>
                        <span class="text-wrap text-break d-block">
                            {{ __('project/public_protocol.feature_review_options.' . $feature, [], app()->getLocale())
                                !== 'project/public_protocol.feature_review_options.' . $feature
                                ? __('project/public_protocol.feature_review_options.' . $feature)
                                : $feature }}
                        </span>
            </div>

        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Descrição -->
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">{{ __("project/overview.description") }}</h5>
            </div>
            <div class="card-body">
                <p class="mb-0 text-muted">{{ $project->description }}</p>
            </div>
        </div>
    </div>

    <!-- Objetivos -->
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">{{ __("project/overview.objectives") }}</h5>
            </div>
            <div class="card-body">
                <p class="mb-0 text-muted">{{ $project->objectives }}</p>
            </div>
        </div>
    </div>

    <!-- Membros -->
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">{{ __("project/overview.members") }}</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @foreach ($users_relation as $user)
                        <li class="mb-0">
                            <i class="bi bi-person-circle me-1 text-secondary"></i>
                            <span>{{ $user->username }} - <small class="text-muted">{{ $user->level_name }}</small></span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Progresso e Atividades -->
<div class="row g-3 mt-3">
    <!-- Progresso -->
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header thoth-card-header mb-0 pb-0">

                <x-helpers.modal
                    target="project-status-help"
                    modalTitle="{{ __('project/overview.progress') }}"
                    modalContent="{!! __('project/overview.project_status_help.content') !!}"
                />
            </div>
            <div class="card-body">

                {{-- Planning --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">{{ __("project/overview.planning") }}</span>
                        <span>{{ number_format($planningProgress["overall"] ?? 0, 2) }}%</span>
                    </div>
                    <div class="progress" style="height: 18px;">
                        <div class="progress-bar bg-primary"
                             style="width: {{ $planningProgress["overall"] ?? 0 }}%"
                             aria-valuenow="{{ $planningProgress["overall"] ?? 0 }}"
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                {{-- Conducting --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">{{ __("project/overview.conducting") }}</span>
                        <span>{{ number_format($conductingProgress['overall'] ?? 0, 2) }}%</span>
                    </div>
                    <div class="progress" style="height: 18px;">
                        <div class="progress-bar bg-success"
                             style="width: {{ $conductingProgress['overall'] ?? 0 }}%"
                             aria-valuenow="{{ $conductingProgress['overall'] ?? 0 }}"
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                {{-- Study Selection --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">{{ __('project/overview.study-selection') }}</span>
                        <span>{{ number_format($conductingProgress['study_selection'] ?? 0, 2) }}%</span>
                    </div>
                    <div class="progress" style="height: 18px;">
                        <div class="progress-bar bg-dark"
                             style="width: {{ $conductingProgress['study_selection'] ?? 0 }}%"
                             aria-valuenow="{{ $conductingProgress['study_selection'] ?? 0 }}"
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                {{-- Quality Assessment --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">{{ __('project/overview.quality_assessment') }}</span>
                        <span>{{ number_format($conductingProgress['quality_assessment'] ?? 0, 2) }}%</span>
                    </div>
                    <div class="progress" style="height: 18px;">
                        <div class="progress-bar bg-info"
                             style="width: {{ $conductingProgress['quality_assessment'] ?? 0 }}%"
                             aria-valuenow="{{ $conductingProgress['quality_assessment'] ?? 0 }}"
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                @if($project->hasSnowballing())
                {{-- Snowballing --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ __('project/overview.snowballing') }}</span>
                            <span>{{ number_format($conductingProgress['snowballing'] ?? 0, 2) }}%</span>
                        </div>
                        <div class="progress" style="height: 18px;">
                            <div class="progress-bar bg-secondary"
                                 style="width: {{ $conductingProgress['snowballing'] ?? 0 }}%"
                                 aria-valuenow="{{ $conductingProgress['snowballing'] ?? 0 }}"
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                @endif


                {{-- Data Extraction --}}
                <div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">{{ __('project/overview.data_extraction') }}</span>
                        <span>{{ number_format($conductingProgress['data_extraction'] ?? 0, 2) }}%</span>
                    </div>
                    <div class="progress" style="height: 18px;">
                        <div class="progress-bar bg-danger"
                             style="width: {{ $conductingProgress['data_extraction'] ?? 0 }}%"
                             aria-valuenow="{{ $conductingProgress['data_extraction'] ?? 0 }}"
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                @php
                    $isAdmin = $project->userHasLevel(auth()->user(), '1');
                @endphp

                @if($isAdmin)
                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small fw-semibold">
                {{ __('project/overview.project_status') }}:
            </span>

                            @if($project->is_finished)
                                <span class="badge bg-success d-inline-flex align-items-center gap-1 px-3 py-2">
                    <i class="fas fa-check-circle"></i>
                    {{ __('project/overview.finished_project') }}
                </span>
                            @else
                                <span class="badge bg-light text-dark d-inline-flex align-items-center gap-1 px-3 py-2">
                    <i class="fas fa-spinner"></i>
                    {{ __('project/overview.ongoing_project') }}
                </span>
                            @endif
                        </div>

                        @if(!$project->is_finished)
                            <form method="POST" action="{{ route('projects.finish', $project->id_project) }}" class="mb-0">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-success btn-sm d-inline-flex align-items-center gap-2 px-3 mb-0">
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('project/overview.mark_as_finished') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('projects.reopen', $project->id_project) }}" class="mb-0">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center gap-2 px-3 mb-0">
                                    <i class="fas fa-undo-alt"></i>
                                    {{ __('project/overview.mark_as_ongoing') }}
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
    <!-- Atividades -->
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">{{ __('project/overview.activity_record') }}</h5>
            </div>
            <div class="card-body p-3" style="max-height:400px; overflow-y:auto;">
                @if (!empty($activities))
                    @foreach ($activities->take(10) as $activity)
                        <div class="border rounded-3 mb-3">
                            <div class="bg-light px-3 py-2 fw-semibold">
                                {{ $activity->user->username }}
                            </div>
                            <div class="px-3 py-2">
                                {{ $activity->activity }}
                            </div>
                            <div class="bg-light text-muted px-3 py-1 small">
                                @php
                                    $locale = app()->getLocale();
                                    $date = \Carbon\Carbon::parse($activity->created_at)->locale($locale);
                                    $format = $locale === 'pt_BR' || $locale === 'pt' ? 'd/m/Y H:i' : 'm/d/Y h:i A';
                                @endphp
                                {{ $date->translatedFormat($format) }}
                            </div>
                        </div>
                    @endforeach

                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#allActivitiesModal">
                            {{ __('project/overview.view_full_history') }}
                        </button>
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        {{ __('project/overview.no_activities') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal: Histórico Completo -->
<div class="modal fade" id="allActivitiesModal" tabindex="-1" aria-labelledby="allActivitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allActivitiesModalLabel">{{ __('project/overview.full_activity_history') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (!empty($activities) && $activities->count())
                    @foreach ($activities as $activity)
                        <div class="card p-0 mb-3 border rounded-3 text-start">
                            <div class="card-header bg-light rounded-top py-2">
                                <strong>{{ $activity->user->username }}</strong>
                            </div>
                            <div class="card-body bg-white py-2">
                                {{ $activity->activity }}
                            </div>
                            <div class="card-footer text-muted py-2">
                                <small>
                                    @php
                                        $locale = app()->getLocale();
                                        $date = \Carbon\Carbon::parse($activity->created_at)->locale($locale);
                                        $format = $locale === 'pt_BR' || $locale === 'pt' ? 'd/m/Y H:i' : 'm/d/Y h:i A';
                                    @endphp
                                    {{ $date->translatedFormat($format) }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-3">
                        {{ __('project/overview.no_activities') }}
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <a href="{{ route('projects.exportActivities', ['project' => $project->id_project]) }}" class="btn btn-warning btn-sm">
                    {{ __('project/overview.export') }}
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    {{ __('project/overview.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

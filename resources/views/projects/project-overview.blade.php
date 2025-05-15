<div class="card-group justify-content-center">
    <div class="card">
        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <h5>{{ __('project/overview.description') }}</h5>
        </div>
        <div class="card-body pt-2">
            <p>{{ $project->description }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <h5>{{ __('project/overview.objectives') }}</h5>
        </div>
        <div class="card-body pt-2">
            <p>{{ $project->objectives }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <h5>{{ __('project/overview.members') }}</h5>
        </div>
        <div class="card-body pt-2">
            <ul>
                @foreach ($users_relation as $user)
                    <li>
                        <span>{{ $user->username }} - {{ $user->level_name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="card card-frame mt-5">
    <div class="card-group">
        <div class="card">
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                <h5>{{ __('project/overview.progress') }}</h5>
            </div>
            <div class="card-body">
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-sm font-weight-bold">{{ __('project/overview.planning') }}</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                            aria-valuemax="100" style="width: 60%;"></div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-sm font-weight-bold">{{ __('project/overview.import_studies') }}</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                            aria-valuemax="100" style="width: 70%;"></div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-sm font-weight-bold">{{ __('project/overview.study_selection') }}</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                            aria-valuemax="100" style="width: 50%;"></div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-sm font-weight-bold">{{ __('project/overview.quality_assessment') }}</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                            aria-valuemax="100" style="width: 20%;"></div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div class="progress-percentage">
                            <span class="text-sm font-weight-bold">{{ __('project/overview.data_extraction') }}</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                            aria-valuemax="100" style="width: 95%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                <h5>{{ __('project/overview.activity_record') }}</h5>
            </div>
            <div style="max-height:390px; overflow-y: auto;">
                @if (!empty($activities))
                    @foreach ($activities->take(10) as $activity)
                        <div class="card p-0 mx-3 mt-3 border rounded-3 text-start">
                            <div class="card-header bg-light rounded-top pt-3 pb-3">
                                <strong>{{ $activity->user->username }}</strong>
                            </div>
                            <div class="card-body bg-white pt-3 pb-3">{{ $activity->activity }}</div>
                            <div class="card-footer text-muted pt-2 pb-2"><small>
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

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#allActivitiesModal">
                            {{ __('project/overview.view_full_history') }}
                        </button>
                    </div>
                @endif

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
                        </div>
                       </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

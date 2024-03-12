<div class="col-12">
    <div class="card bg-secondary-overview">
        <div class="card-body">
            <div class="card-group card-frame mt-1">
                <div class="card">
                    <div>
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0">{{ __('project/planning.criteria.title') }}</p>
                                @include ('components.help-button', ['dataTarget' => 'CriteriaHelpModal'])
                                <!-- Help Button Description -->
                                @include('components.help-modal', [
                                    'modalId' => 'CriteriaHelpModal',
                                    'modalLabel' => 'exampleModalLabel',
                                    'modalTitle' => __('project/planning.criteria.help.title'),
                                    'modalContent' => __('project/planning.criteria.help.content'),
                                ])
                            </div>
                        </div>
                        <div class="card-body">
                            @include('project.planning.criteria.partials.criteria-form')
                        </div>

                        <div class="card-group">
                            @include('project.planning.criteria.partials.inclusion-criteria')
                            @include('project.planning.criteria.partials.exclusion-criteria')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="modal fade" id="paperModalSnowballingRelevant" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($paper)
                        <h5 class="modal-title">{{ $paper['title'] }}</h5>
                        <button type="button" data-bs-dismiss="modal" class="btn">
                            <span aria-hidden="true">X</span>
                        </button>
                    @endif
                </div>

                @if ($paper)
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <b>{{ __('project/conducting.snowballing.modal.author') }}: </b>
                                <p>{{ $paper['authors'] }}</p>
                            </div>
                            <div class="col-1">
                                <b>{{ __('project/conducting.snowballing.modal.year') }}:</b>
                                <p>{{ $paper['year'] }}</p>
                            </div>
                            <div class="col-4">
                                <b>{{ __('project/conducting.snowballing.modal.database') }}:</b>
                                <p>{{ $paper['database_name'] }}</p>
                            </div>
                            <div class="col-3 text-end">
                                @if($paper['doi'])
                                    <a class="btn py-1 px-3 btn-outline-dark" href="https://doi.org/{{ $paper['doi'] }}" target="_blank">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> DOI
                                    </a>
                                @endif
                                @if($paper['url'])
                                    <a class="btn py-1 px-3 btn-outline-success" href="{{ $paper['url'] }}" target="_blank">
                                        <i class="fa-solid fa-link"></i> URL
                                    </a>
                                @endif
                                <a class="btn py-1 px-3 btn-outline-primary"
                                   href="https://scholar.google.com/scholar?q={{ urlencode($paper['title']) }}"
                                   target="_blank">
                                    <i class="fa-solid fa-graduation-cap"></i> Scholar
                                </a>
                            </div>

                            <div class="col-12 mt-3">
                                <b>{{ __('project/conducting.snowballing.modal.abstract') }}: </b>
                                <p>{{ $paper['abstract'] }}</p>
                            </div>
                            <div class="col-12">
                                <b>{{ __('project/conducting.snowballing.modal.keywords') }}: </b>
                                <p>{{ $paper['keywords'] }}</p>
                            </div>
                        </div>

                        <hr />
                        @livewire('conducting.snowballing.references-table-relevant', ['data' => ['parent_snowballing_id' => $paper['id'] ?? null]])
                    </div>
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('project/conducting.snowballing.modal.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $(document).ready(function(){
            $wire.on('show-paper-snowballing-relevant', () => {
                setTimeout(() => { $('#paperModalSnowballingRelevant').modal('show'); }, 500);
            });
        });
    </script>
    @endscript
</div>

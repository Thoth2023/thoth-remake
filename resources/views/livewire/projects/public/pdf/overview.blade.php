{{-- OVERVIEW --}}
<div style="clear:both; margin-top:10px;"></div>
    <div class="row">
        <div class="col-half">
            <div class="protocol-box">
                <strong>{{ __('project/public_protocol.domains') }}:</strong>
                <ul>
                    @forelse($domains as $d) <li>{{ $d->description }}</li> @empty <li>—</li> @endforelse
                </ul>
            </div>
        </div>
        <div class="col-half">
            <div class="protocol-box">
                <strong>{{ __('project/public_protocol.languages') }}:</strong>
                <ul>
                    @forelse($languages as $l) <li>{{ $l->description }}</li> @empty <li>—</li> @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-half">
            <div class="protocol-box">
                <strong>{{ __('project/public_protocol.study_types') }}:</strong>
                <ul>
                    @forelse($studyTypes as $s) <li>{{ __("project/planning.overall.study_type.types.$s->description") }}</li> @empty <li>—</li> @endforelse
                </ul>
            </div>
        </div>
        <div class="col-half">
            <div class="protocol-box">
                <strong>{{ __('project/public_protocol.keywords') }}:</strong>
                <ul>
                    @forelse($keywords as $k) <li>{{ $k->description ?? $k->keyword }}</li> @empty <li>—</li> @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="protocol-box">
                <strong>{{ __('project/public_protocol.databases') }}:</strong>
                <ul>
                    @forelse($databases as $db) <li>{{ $db->name ?? $db->description }}</li> @empty <li>—</li> @endforelse
                </ul>
            </div>
        </div>
    </div>


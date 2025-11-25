<style>
    .protocol-box {
        background: #f9fafb;
        border: 1px solid #e3e6ea;
        border-radius: 8px;
        padding: 12px 15px;
        height: 100%;
        font-size: 0.9rem;

    }

    .protocol-box strong {
        font-size: 0.85rem;
        color: #344767;
    }
    .protocol-box ul {
        padding-left: 18px !important;
        margin-bottom: 0;
        max-width: 100%;
    }
    .protocol-box li {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        margin-bottom: 2px;
        white-space: normal;
    }
    .protocol-text {
        white-space: pre-line; /* mantém quebras de linha */
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        hyphens: auto;
    }
</style>

<div class="row g-3 mt-2">

    {{-- Domains --}}
    <div class="col-12 col-md-6 col-lg-3">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.domains') }}:</strong>
            <ul>
                @forelse($domains as $d)
                    <li>{{ $d->description }}</li>
                @empty
                    <li>—</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Languages --}}
    <div class="col-12 col-md-6 col-lg-3">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.languages') }}:</strong>
            <ul>
                @forelse($languages as $l)
                    <li>{{ $l->description }}</li>
                @empty
                    <li>—</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Study Types --}}
    <div class="col-12 col-md-6 col-lg-3">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.study_types') }}:</strong>
            <ul>
                @forelse($studyTypes as $s)
                    <li>{{ __("project/planning.overall.study_type.types.$s->description") }} </li>
                @empty
                    <li>—</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Keywords --}}
    <div class="col-12 col-md-6 col-lg-3">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.keywords') }}:</strong>
            <ul>
                @forelse($keywords as $k)
                    <li>{{ $k->description }}</li>
                @empty
                    <li>—</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Databases --}}
    <div class="col-12 col-md-8">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.databases') }}:</strong>
            <ul>
                @forelse($databases as $db)
                    <li>{{ $db->name }}</li>
                @empty
                    <li>—</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Project Dates --}}
    <div class="col-12 col-md-4">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.project_dates') }}:</strong>
            <div>{{ __('project/public_protocol.start') }}: {{ $project->start_date ?? '—' }}</div>
            <div>{{ __('project/public_protocol.end') }}: {{ $project->end_date ?? '—' }}</div>
        </div>
    </div>

</div>

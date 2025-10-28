@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __("pages/news-sources.add_source")])

    <div class="container mt-4 mb-3">
        <div class="card p-4 shadow-sm border-0">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-rss text-dark me-2"></i> {{ __("pages/news-sources.add_source") }}
            </h5>

            <form method="POST" action="{{ route('news-sources.store') }}">
                @csrf

                {{-- Nome da Fonte --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        {{ __("pages/news-sources.name") }}
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           placeholder="Ex: IEEE, SBC, ACM..."
                           required
                           value="{{ old('name') }}">
                </div>

                {{-- URL do Feed (RSS) --}}
                <div class="mb-3">
                    <label for="url" class="form-label fw-semibold">
                        {{ __("pages/news-sources.url") }}
                        <i class="fas fa-rss text-warning ms-1"></i>
                    </label>
                    <input type="url"
                           name="url"
                           id="url"
                           class="form-control"
                           placeholder="Ex: https://www.sbc.org.br/feed/"
                           required
                           value="{{ old('url') }}">
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-info-circle me-1 text-secondary"></i>
                        {{ __("pages/news-sources.url_helper") }}
                    </small>
                </div>

                {{-- Link "Ver mais" --}}
                <div class="mb-3">
                    <label for="more_link" class="form-label fw-semibold">
                        {{ __('pages/news-sources.more_link') }}
                        <i class="fas fa-external-link-alt text-secondary ms-1"></i>
                    </label>
                    <input type="url"
                           class="form-control"
                           id="more_link"
                           name="more_link"
                           placeholder="https://www.sbc.org.br/noticias"
                           value="{{ old('more_link') }}">
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-lightbulb me-1 text-secondary"></i>
                        {{ __("pages/news-sources.more_link_helper") }}
                    </small>
                </div>

                {{-- Ativo --}}
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input"
                           type="checkbox"
                           id="active"
                           name="active"
                           value="1"
                        {{ old('active', true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="active">
                        {{ __('pages/news-sources.active_source') }}
                    </label>
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-toggle-on me-1 text-secondary"></i>
                        {{ __("pages/news-sources.active_helper") }}
                    </small>
                </div>

                {{-- Botões --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('news-sources.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> {{ __("pages/news-sources.back") }}
                    </a>

                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save me-1"></i> {{ __("pages/news-sources.save") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

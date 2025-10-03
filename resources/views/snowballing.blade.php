@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section('content')
    @include("layouts.navbars.auth.topnav", ["title" => __("nav/topnav.planning")])

    <div class="container mt-2 mb-8">
        <div class="row">
            <div class="col-12">
                <div class="card d-inline-flex mt-5 w-100">
                    <div class="card-body pt-3">

                        <div class="h5">
                        <x-helpers.modal
                            target="snowballing-help"
                            modalTitle="{{ __('snowballing.title') }}"
                            modalContent="{!! __('snowballing.modal.content') !!}"
                        />
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('snowballing.fetch') }}" class="mb-4">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-10">
                                    <label for="qInput" class="form-label fw-bold">{{ __('snowballing.input_label') }}</label>
                                    <input
                                        type="text"
                                        name="q"
                                        id="qInput"
                                        class="form-control @error('q') is-invalid @enderror"
                                        placeholder="{{ __('snowballing.input_placeholder') }}"
                                        value="{{ old('q', $q ?? '') }}"
                                        required
                                    />
                                    @error('q') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-2 mb-0">
                                    <button type="submit" class="btn btn-primary w-100 mb-0">{{ __('snowballing.submit') }}</button>
                                </div>
                            </div>
                        </form>

                        {{-- Cabeçalho do artigo retornado (semente) --}}
                        @isset($article)
                            <div class="card border mb-4">
                                <div class="card-body">
                                    <h6 class="mb-1">{{ $article['title'] ?? 'Título não disponível' }}</h6>
                                    <div class="text-muted mb-2">
                                        {{ $article['authors'] }} {!! $article['year'] ? '· <strong>'.$article['year'].'</strong>' : '' !!}
                                    </div>
                                    <div class="small">
                                        @if(!empty($article['doi']))
                                            <span class="badge bg-light text-dark me-2">DOI: {{ $article['doi'] }}</span>
                                        @endif
                                        @if(!empty($article['url']))
                                                <a class="badge text-warning border border-warning text-decoration-none"
                                                   href="{{ $article['url'] }}"
                                                   target="_blank"
                                                   rel="noopener">
                                                    Abrir no Semantic Scholar
                                                </a>
                                        @endif
                                    </div>
                                    @if(!empty($article['abstract']))
                                        <hr class="my-3">
                                        <p class="mb-0">{{ $article['abstract'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endisset

                        {{-- Exibição idêntica ao “antes”: Referências e Citações lado a lado --}}
                        @if(!empty($references) || !empty($citations))
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <h6 class="fw-semibold">{{ __('snowballing.references_title') }} @if(!empty($references))
                                            <span class="badge bg-secondary">{{ count($references) }}</span>
                                        @endif</h6>
                                    @if(!empty($references))
                                        <ul class="list-group">
                                            @foreach ($references as $ref)
                                                <li class="list-group-item">
                                                    <div class="fw-semibold">{{ $ref['title'] }}</div>
                                                    <div class="text-muted small">
                                                        {{ $ref['authors'] }} {!! $ref['year'] ? '· '.$ref['year'] : '' !!}
                                                    </div>
                                                    <div class="small mt-1">
                                                        @if($ref['doi'])
                                                            <a href="https://doi.org/{{ $ref['doi'] }}" target="_blank" rel="noopener" class="badge bg-light text-dark me-2">
                                                                DOI: {{ $ref['doi'] }}
                                                            </a>
                                                        @endif
                                                        @if($ref['url'])
                                                                <a href="{{ $ref['url'] }}" target="_blank" rel="noopener" class="badge bg-primary text-decoration-none">
                                                                    {{ __('snowballing.open_semantic') }}
                                                                </a>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">{{ __('snowballing.no_references') }}</p>
                                    @endif
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <h6 class="fw-semibold">{{ __('snowballing.citations_title') }} @if(!empty($citations))
                                            <span class="badge bg-secondary">{{ count($citations) }}</span>
                                        @endif</h6>
                                    @if(!empty($citations))
                                        <ul class="list-group">
                                            @foreach ($citations as $cit)
                                                <li class="list-group-item">
                                                    <div class="fw-semibold">{{ $cit['title'] }}</div>
                                                    <div class="text-muted small">
                                                        {{ $cit['authors'] }} {!! $cit['year'] ? '· '.$cit['year'] : '' !!}
                                                    </div>
                                                    <div class="small mt-1">
                                                        @if($cit['doi'])
                                                            <a href="https://doi.org/{{ $cit['doi'] }}" target="_blank" rel="noopener" class="badge bg-light text-dark me-2">
                                                                DOI: {{ $cit['doi'] }}
                                                            </a>
                                                        @endif
                                                            <a href="{{ $cit['url'] }}" target="_blank" rel="noopener" class="badge bg-primary text-decoration-none">
                                                                {{ __('snowballing.open_semantic') }}
                                                            </a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">{{ __('snowballing.no_citations') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @empty($article)
                            <p class="text-muted mb-0">{{ __('snowballing.tip') }}</p>
                        @endempty

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

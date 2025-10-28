@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __("pages/news-sources.title")])

    <div class="container mt-4 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-2 border-radius-lg">
            <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style="width: 100%">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white" style="font-size: 2rem">
                        {{ __("pages/news-sources.title") }}
                    </h1>
                    <p class="text-lead text-white">
                        {{ __("pages/news-sources.description") }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 mb-3">
        <div class="card table-wrapper">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>{{ __("pages/news-sources.sources_list") }}</h5>
                <a href="{{ route('news-sources.create') }}" class="btn btn-dark btn-sm">
                    <i class="fas fa-plus me-1"></i> {{ __("pages/news-sources.add_source") }}
                </a>
            </div>

            <div class="card-body px-0 pt-0 pb-3">
                <div class="table-responsive">
                    <table class="table table-hover align-items-center mb-0">
                        <thead>
                        <tr>
                            <th>{{ __("pages/news-sources.name") }}</th>
                            <th>{{ __("pages/news-sources.url") }}</th>
                            <th>{{ __("pages/news-sources.more_link") }}</th>
                            <th class="text-center">{{ __("pages/news-sources.status") }}</th>
                            <th class="text-center">{{ __("pages/news-sources.actions") }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sources as $source)
                            <tr>
                                <td><strong>{{ $source->name }}</strong></td>
                                <td><a href="{{ $source->url }}" target="_blank">{{ $source->url }}</a></td>
                                <td><a href="{{ $source->more_link }}" target="_blank">{{ $source->more_link }}</a></td>
                                <td class="text-center">
                                    @if($source->active)
                                        <span class="badge bg-success">{{ __("pages/news-sources.active") }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __("pages/news-sources.inactive") }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Botão Editar --}}
                                        <a href="{{ route('news-sources.edit', $source) }}"
                                           class="btn btn-sm btn-outline-primary px-2 py-1"
                                           title="{{ __('pages/news-sources.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Botão Ativar/Desativar --}}
                                        <form action="{{ route('news-sources.toggle', $source) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-sm {{ $source->active ? 'btn-outline-danger' : 'btn-outline-success' }} px-2 py-1"
                                                    title="{{ $source->active ? __('pages/news-sources.deactivate') : __('pages/news-sources.activate') }}">
                                                <i class="fas {{ $source->active ? 'fa-ban' : 'fa-check' }}"></i>
                                            </button>
                                        </form>

                                        {{-- Botão Excluir --}}
                                        <form action="{{ route('news-sources.destroy', $source) }}" method="POST"
                                              onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-dark px-2 py-1" title="{{ __('pages/news-sources.delete') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

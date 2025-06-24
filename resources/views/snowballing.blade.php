@extends('layouts.app')

@section('content')
<div class="card shadow-sm p-4">
    <h4 class="mb-4">Busca de Referências e Citações (Snowballing com IA)</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('snowballing.fetch') }}">
        @csrf
        <div class="mb-3">
            <label for="doiInput" class="form-label fw-bold">DOI do artigo</label>
            <input
                type="text"
                name="doi"
                id="doiInput"
                class="form-control @error('doi') is-invalid @enderror"
                placeholder="Ex: 10.1145/3368089.3409741"
                value="{{ old('doi', $doi ?? '') }}"
                required
            />
            @error('doi')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mb-3">
            Buscar Referências e Citações
        </button>
    </form>

    @if(!empty($references) || !empty($citations))
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-semibold">🔎 Referências Encontradas</h5>
                @if(!empty($references))
                    <ul class="list-group">
                        @foreach ($references as $ref)
                            <li class="list-group-item">{{ $ref['title'] ?? 'Título não disponível' }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Nenhuma referência encontrada.</p>
                @endif
            </div>
            <div class="col-md-6">
                <h5 class="fw-semibold">📌 Citações Recebidas</h5>
                @if(!empty($citations))
                    <ul class="list-group">
                        @foreach ($citations as $cit)
                            <li class="list-group-item">{{ $cit['title'] ?? 'Título não disponível' }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Nenhuma citação encontrada.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

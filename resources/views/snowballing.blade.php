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

    @if((!empty($citations)) || (!empty($references)))
        <div class="mb-3">
            <button id="btnCitations" class="btn btn-outline-primary me-2 active">📌 Citações Recebidas</button>
            <button id="btnReferences" class="btn btn-outline-primary">🔎 Referências Encontradas</button>
        </div>

        <div id="citationsList" style="display: block;">
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

        <div id="referencesList" style="display: none;">
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
    @endif
</div>

<script>
    const btnCitations = document.getElementById('btnCitations');
    const btnReferences = document.getElementById('btnReferences');
    const citationsList = document.getElementById('citationsList');
    const referencesList = document.getElementById('referencesList');

    btnCitations.addEventListener('click', () => {
        btnCitations.classList.add('active');
        btnReferences.classList.remove('active');
        citationsList.style.display = 'block';
        referencesList.style.display = 'none';
    });

    btnReferences.addEventListener('click', () => {
        btnReferences.classList.add('active');
        btnCitations.classList.remove('active');
        referencesList.style.display = 'block';
        citationsList.style.display = 'none';
    });
</script>
@endsection

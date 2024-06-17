@extends('layouts.app')

// para cada pág, mostra a hora e data em que foi atualizado e mostra a opção de restaurar e deletar.
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Histórico de Versões</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data e Hora</th>
                                <th>Operação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pageVersions as $version)
                            <tr>
                                <td>{{ $version->created_at }}</td>
                                <td>{{ $version->created_at == $version->updated_at ? 'Criação' : 'Atualização' }}</td>
                                <td>
                                    <a href="{{ route('pages.restore', ['pageId' => $version->page_id, 'versionId' => $version->id]) }}" class="btn btn-sm btn-primary">Restaurar</a>
                                    <form action="{{ route('versions.delete', ['versionId' => $version->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

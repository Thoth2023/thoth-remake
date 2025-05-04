@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resultados da Busca</h1>
        <p>Você buscou por: <strong>{{ $query }}</strong></p>

        <form action="{{ route('search') }}" method="GET" class="d-flex">
            <input type="text" name="query" class="form-control" placeholder="Buscar...">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        @if($results->isEmpty())
            <p>Nenhum resultado encontrado.</p>
        @else
            <ul>
                @foreach($results as $result)
                    <li>
                        <a href="{{ route('projects.show', $result->id) }}">{{ $result->title }}</a>
                        <p>{{ $result->description }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
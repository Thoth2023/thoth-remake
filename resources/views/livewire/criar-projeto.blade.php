@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Criar Projeto'])

    <div class="card shadow-lg mx-4">
        <div class="container-fluid py-4">
            <p class="text-uppercase text-sm">Create Project</p>

            <form wire:submit.prevent="save">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input wire:model="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter the title">
                    @error('title') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Enter the description"></textarea>
                    @error('description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="objectives">Objectives</label>
                    <textarea wire:model="objectives" class="form-control @error('objectives') is-invalid @enderror" rows="3" placeholder="Enter the objectives"></textarea>
                    @error('objectives') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="copy_planning">Copiar Planejamento</label>
                    <select wire:model="copy_planning" class="form-control">
                        <option value="none">Nenhum</option>
                        @php $projetos = $projects ?? [] @endphp

@if (!empty($projetos) && count($projetos) > 0)
    @foreach($projetos as $project)
        <option value="{{ $project->id_project }}">{{ $project->title }}</option>
    @endforeach
@else
    <option value="none">Usuário ainda não possui projetos criados</option>
                        @endif
                    </select>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model="feature_review" id="feature_review1" value="Systematic review">
                    <label class="form-check-label" for="feature_review1">Systematic review</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model="feature_review" id="feature_review2" value="Systematic review and Snowballing">
                    <label class="form-check-label" for="feature_review2">Systematic review and Snowballing</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model="feature_review" id="feature_review3" value="Snowballing">
                    <label class="form-check-label" for="feature_review3">Snowballing</label>
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" wire:model="has_peer_review" id="peer_review">
                    <label class="form-check-label" for="peer_review">Avaliação por Pares</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="has_reviewer" id="reviewer">
                    <label class="form-check-label" for="reviewer">Revisor</label>
                </div>

                <div class="d-flex align-items-center mt-4">
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Create</button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
@endsection

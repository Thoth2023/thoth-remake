@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @livewire('editar-projeto', ['id' => $id])


    <div class="container-fluid py-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <form wire:submit.prevent="update">
                    <div class="form-group">
                        <label for="titleInput">Title</label>
                        <input wire:model="title" type="text" class="form-control" id="titleInput" placeholder="Enter the title">
                        @error('title') <span class="text-danger">{{ \$message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="descriptionTextarea">Description</label>
                        <textarea wire:model="description" class="form-control" id="descriptionTextarea" rows="3" placeholder="Enter the description"></textarea>
                        @error('description') <span class="text-danger">{{ \$message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="objectivesTextarea">Objectives</label>
                        <textarea wire:model="objectives" class="form-control" id="objectivesTextarea" rows="3" placeholder="Enter the objectives"></textarea>
                        @error('objectives') <span class="text-danger">{{ \$message }}</span> @enderror
                    </div>

                    <div class="form-check mt-3">
                        <input wire:model="has_peer_review" class="form-check-input" type="checkbox" id="peer_review">
                        <label class="form-check-label" for="peer_review">Avaliação por Pares</label>
                    </div>

                    <div class="form-check">
                        <input wire:model="has_reviewer" class="form-check-input" type="checkbox" id="reviewer">
                        <label class="form-check-label" for="reviewer">Revisor</label>
                    </div>

                    <div class="form-check">
                        <input wire:model="is_public" class="form-check-input" type="checkbox" id="is_public">
                        <label class="form-check-label" for="is_public">Projeto Público</label>
                    </div>

                    <div class="d-flex align-items-center mt-3">
                        <button type="submit" class="btn btn-success btn-sm ms-auto">Atualizar Projeto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include("layouts.footers.auth.footer")
    @endsection


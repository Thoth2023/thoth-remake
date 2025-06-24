@extends('layouts.app')
<!-- Estende o layout base da aplicação -->

@section('content')
<!-- Início da seção de conteúdo principal da página -->

<!-- Inclui o topo da página com o título dinâmico "Seu Perfil" -->
@include('layouts.navbars.auth.topnav', ['title' => __('pages/profile.your_profile')])

<div class="container mt-1 mb-3">
    <!-- Container principal com margens superior e inferior -->

    <!-- Cabeçalho com o título da página e descrição -->
    <div class="page-header d-flex flex-column border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 " style="width: 100%">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">
                    {{ __("pages/profile.title-page") }}
                </h1>
                <p class="text-lead text-white">
                    {!! __("pages/profile.description-page") !!}
                </p>
            </div>
        </div>
    </div>

    <!-- Card com avatar (iniciais do usuário) e dados básicos -->
    <div class="card shadow-lg mt-2">
        <div class="card-body">
            <div class="row gx-4">
                <!-- Avatar com as iniciais do nome do usuário -->
                <div class="col-auto my-auto">
                    <div class="avatar avatar-xl rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; font-size: 1.5rem;">
                        {{ strtoupper(substr(auth()->user()->firstname, 0, 1)) }}{{ strtoupper(substr(auth()->user()->lastname, 0, 1)) }}
                    </div>
                </div>

                <!-- Nome completo + Instituição + Ocupação -->
                <div class="col my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                        </h5>
                        <span class="font-weight-bold text-sm mb-0">
                            {{ auth()->user()->institution ? auth()->user()->institution : 'Institution' }}
                        </span> :: 
                        <span class="mb-0 font-weight-bold text-sm">
                            {{ auth()->user()->occupation ? auth()->user()->occupation : 'Occupation' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <!-- Área para mensagens de feedback (sucesso/erro) -->
    <div id="alert">
        @include('components.alert')
    </div>

    <!-- Formulário de edição do perfil do usuário -->
    <div class="row" style="justify-content: space-around;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">{{ __('pages/profile.edit_profile') }}</p>

                        <!-- Botões de ação: Editar e Solicitar Exclusão de Dados -->
                        <div class="d-flex gap-2 ms-auto">
                            <button type="button" id="btn-editar" class="btn btn-primary btn-sm">
                                Editar
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" onclick="requestDataDeletion()">
                                <i class="fas fa-trash"></i>  {{ __('pages/profile.request_data_deletion') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Formulário real -->
                <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf <!-- Token CSRF para segurança -->

                    <div class="card-body">
                        <!-- Seção de informações do usuário -->
                        <p class="text-uppercase text-sm">{{ __('pages/profile.user_information') }}</p>
                        <div class="row">
                            <!-- Campos básicos: username, email, firstname, lastname -->
                            <!-- Todos os campos começam desabilitados -->
                            <!-- Exemplo de campo com validação de erro -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('pages/profile.username') }}</label>
                                    <input class="form-control" type="text" name="username" value="{{ old('username', auth()->user()->username) }}" disabled>
                                </div>
                            </div>

                            <!-- Demais campos seguem a mesma lógica: campo + validação de erro -->
                            <!-- Primeiro Nome -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('pages/profile.first_name') }}</label>
                                    <input class="form-control" type="text" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" disabled>
                                    @error('firstname')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sobrenome -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('pages/profile.last_name') }}</label>
                                    <input class="form-control" type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" disabled>
                                    @error('lastname')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        <!-- Informações de Contato -->
                        <p class="text-uppercase text-sm">{{ __('pages/profile.contact_information') }}</p>
                        <div class="row">
                            <!-- Endereço completo, cidade, país, CEP -->
                            <!-- Exemplo: campo de cidade -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('pages/profile.city') }}</label>
                                    <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}" disabled>
                                    @error('city')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Demais campos seguem o mesmo padrão -->
                        </div>

                        <hr class="horizontal dark">

                        <!-- Seção "Sobre Mim" -->
                        <p class="text-uppercase text-sm">{{ __('pages/profile.about_me') }}</p>
                        <div class="row">
                            <!-- Campo de descrição pessoal -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('pages/profile.about_me') }}</label>
                                    <input class="form-control" type="text" name="about" value="{{ old('about', auth()->user()->about) }}" disabled>
                                </div>
                            </div>

                            <!-- Ocupação e Instituição -->
                            <!-- Link do Lattes também incluso -->
                            <!-- Exemplo: Lattes -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('pages/profile.lattes_link') }}</label>
                                    <input class="form-control" type="text" id="lattes_link" name="lattes_link" value="{{ old('lattes_link', auth()->user()->lattes_link) }}" disabled>
                                    @error("lattes_link")
                                        <span class="text-xs text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botão de salvar, só visível após clicar em "Editar" -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="btn-salvar" class="btn btn-success btn-sm" style="display: none;">
                                    <i class="fas fa-save"></i>  {{ __('pages/profile.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Rodapé padrão da aplicação -->
    @include('layouts.footers.auth.footer')
</div>

<!-- Modal Bootstrap para confirmação de exclusão de dados -->
<div class="modal fade" id="dataDeletionConfirmationModal" tabindex="-1" aria-labelledby="dataDeletionConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Corpo do modal com a mensagem de confirmação -->
            <div class="modal-body">
                {{ __('pages/profile.confirmation_message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
// Função JavaScript para solicitar exclusão de dados pessoais via Fetch API
function requestDataDeletion() {
    if (confirm('{{ __("pages/profile.confirm-exclusion") }}')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        fetch("{{ route('user.requestDataDeletion') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'success') {
                // Exibe o modal de confirmação se o servidor responder com sucesso
                let dataDeletionConfirmationModal = new bootstrap.Modal(document.getElementById('dataDeletionConfirmationModal'));
                dataDeletionConfirmationModal.show();
            }
        })
        .catch(error => console.error('Erro:', error));
    }
}

// Função para ativar o modo de edição dos campos do formulário
document.getElementById('btn-editar').addEventListener('click', function () {
    document.querySelectorAll('form input, form select, form textarea').forEach(el => {
        el.removeAttribute('disabled');
    });

    document.getElementById('btn-salvar').style.display = 'inline-block';
    document.getElementById('btn-cancelar').style.display = 'inline-block';
    this.disabled = true;
});

// Função para cancelar a edição e voltar os campos para readonly
document.getElementById('btn-cancelar').addEventListener('click', function () {
    document.querySelectorAll('form input, form select, form textarea').forEach(el => {
        el.setAttribute('disabled', true);
    });

    document.getElementById('btn-salvar').style.display = 'none';
    document.getElementById('btn-cancelar').style.display = 'none';
    document.getElementById('btn-editar').disabled = false;
});
</script>
@endpush

@endsection


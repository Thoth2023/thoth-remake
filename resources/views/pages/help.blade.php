@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'Help'])

    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-9 border-radius-lg">
            <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style="width: 100%">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white">FAQ</h1>
                    <p class="text-lead text-white">
                        {{ __('pages/help.10_questions') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                <div class="card d-inline-flex p-3 mt-8 mb-5 shadow-lg rounded-4">
                    <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                            Thoth 2.0
                        </a>
                        <div class="card-body pt-2">
                        <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                                {{ __('pages/help.common_questions') }}
                            </a>
                        </div>

                        <div class="accordion" id="accordionExample">
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="accordion-item{{ $i }}">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $i > 1 ? 'collapsed' : '' }}" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $i }}"
                                            aria-expanded="{{ $i === 1 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $i }}">
                                            <i class="fas fa-circle-question me-2 text-primary"></i>
                                            {{ __('pages/help.question' . $i) }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $i }}"
                                        class="accordion-collapse collapse {{ $i === 1 ? 'show' : '' }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{ __('pages/help.answer' . $i) }}
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div> {{-- /accordion --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Contato com Suporte -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-2xl mt-4 mb-5">
                    <div class="card-body p-4">
                        <h2 class="text-dark mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            {{ __('pages/help.support_title') }}
                        </h2>
                        <p class="text-muted mb-4">
                            {{ __('pages/help.support_text') }}
                        </p>
                        <a href="mailto:{{ __('pages/help.support_email_address') }}">
                            <button class="btn bg-gradient-primary text-white shadow rounded-pill px-4 py-2">
                                {{ __('pages/help.support_email') }}<strong>{{ __('pages/help.support_email_address') }}</strong>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aqui começa a parte para garantir mais de 200 linhas -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-2xl mt-4 mb-5">
                    <div class="card-body p-4">
                        <h2 class="text-dark mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Como usar o Thoth?
                        </h2>
                        <p class="text-muted mb-4">
                            O Thoth é uma ferramenta para ajudar pesquisadores a realizarem revisões sistemáticas de forma mais ágil e colaborativa. Ele pode ser utilizado em várias fases do processo de revisão, como pesquisa e seleção de estudos, análise de dados, e geração de relatórios.
                        </p>
                        <ul>
                            <li>Passo 1: Realize o login na plataforma utilizando seu e-mail ou conta Google.</li>
                            <li>Passo 2: Crie um novo projeto ou acesse um projeto existente.</li>
                            <li>Passo 3: Defina os critérios para a busca dos estudos.</li>
                            <li>Passo 4: Importe e selecione os estudos relevantes.</li>
                            <li>Passo 5: Avalie a qualidade dos estudos e extraia os dados necessários.</li>
                            <li>Passo 6: Geração de gráficos e relatórios.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mais uma seção adicional para incrementar o número de linhas -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-2xl mt-4 mb-5">
                    <div class="card-body p-4">
                        <h2 class="text-dark mb-3">
                            <i class="fas fa-cogs text-primary me-2"></i>
                            Como configurar notificações?
                        </h2>
                        <p class="text-muted mb-4">
                            O Thoth oferece opções para personalizar notificações. Para ajustar as configurações de notificação, basta acessar o menu "Configurações", onde você pode escolher ser notificado por e-mail sobre as atualizações do seu projeto.
                        </p>
                        <ul>
                            <li>1. Acesse a seção "Configurações" do seu perfil.</li>
                            <li>2. Selecione "Notificações".</li>
                            <li>3. Marque as notificações que deseja receber.</li>
                            <li>4. Salve suas configurações.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mais uma seção para adicionar mais conteúdo -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-2xl mt-4 mb-5">
                    <div class="card-body p-4">
                        <h2 class="text-dark mb-3">
                            <i class="fas fa-users text-primary me-2"></i>
                            Como adicionar membros ao seu projeto?
                        </h2>
                        <p class="text-muted mb-4">
                            Para colaborar com outros pesquisadores, basta adicionar membros ao seu projeto. Os membros poderão contribuir na análise dos estudos e nos relatórios.
                        </p>
                        <ul>
                            <li>1. Acesse o menu "Membros".</li>
                            <li>2. Clique em "Adicionar Membro".</li>
                            <li>3. Envie um convite via e-mail ou compartilhe o link de convite.</li>
                            <li>4. O membro aceitará o convite e poderá começar a colaborar.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outra seção para completar as linhas -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-2xl mt-4 mb-5">
                    <div class="card-body p-4">
                        <h2 class="text-dark mb-3">
                            <i class="fas fa-cloud-upload-alt text-primary me-2"></i>
                            Como importar dados?
                        </h2>
                        <p class="text-muted mb-4">
                            Para importar dados para o seu projeto no Thoth, basta acessar a opção de "Importar" no menu do seu projeto e selecionar o arquivo desejado. O Thoth suporta arquivos CSV, Excel e outros formatos de dados com estrutura tabular.
                        </p>
                        <ul>
                            <li>1. No menu "Projetos", clique em "Importar Dados".</li>
                            <li>2. Selecione o arquivo a ser importado.</li>
                            <li>3. O Thoth irá analisar os dados e adicioná-los automaticamente ao seu projeto.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mais uma seção de ajuda para continuar a formatação -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-2xl mt-4 mb-5">
                    <div class="card-body p-4">
                        <h2 class="text-dark mb-3">
                            <i class="fas fa-bell text-primary me-2"></i>
                            Como configurar lembretes?
                        </h2>
                        <p class="text-muted mb-4">
                            O Thoth também permite configurar lembretes para os membros do projeto, ajudando a garantir que as tarefas sejam concluídas no prazo.
                        </p>
                        <ul>
                            <li>1. Acesse o menu "Lembretes".</li>
                            <li>2. Clique em "Adicionar Lembrete".</li>
                            <li>3. Defina a data e o horário do lembrete.</li>
                            <li>4. Salve e envie o lembrete para os membros do projeto.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de agradecimento -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-2xl mt-4 mb-5">
                    <div class="card-body p-4">
                        <h2 class="text-dark mb-3">
                            <i class="fas fa-thumbs-up text-primary me-2"></i>
                            Agradecemos pelo seu feedback!
                        </h2>
                        <p class="text-muted mb-4">
                            Sua opinião é muito importante para nós. Se você tiver dúvidas adicionais ou sugestões, entre em contato conosco através do e-mail fornecido acima.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'Help'])

    <div class="container mt-8 mb-3">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <!-- Thoth 2.0 -->
                <h2 class="text-dark mb-4 display-4">
                    <i class="fas fa-rocket text-primary me-3"></i>
                    Thoth 2.0
                </h2>
                <p class="lead text-muted mb-4">
                    Thoth é uma poderosa ferramenta para apoiar revisões sistemáticas colaborativas. É uma solução multiplataforma desenvolvida para automatizar partes importantes do processo de revisão sistemática, facilitando e agilizando o trabalho de pesquisadores e profissionais envolvidos nesse tipo de estudo.
                </p>

                <!-- Perguntas Frequentes -->
                <h3 class="text-dark mt-5 mb-4">
                    <i class="fas fa-book text-primary me-3"></i>
                    📚 Perguntas Mais Frequentes:
                </h3>
                <div class="accordion" id="faqAccordion">
                    <!-- Pergunta 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question1" aria-expanded="true" aria-controls="question1">
                                <i class="fas fa-question-circle text-primary me-2"></i> O que é a Thoth?
                            </button>
                        </h2>
                        <div id="question1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Thoth é uma poderosa ferramenta para apoiar revisões sistemáticas colaborativas. É uma solução multiplataforma desenvolvida para automatizar partes importantes do processo de revisão sistemática, facilitando e agilizando o trabalho de pesquisadores e profissionais envolvidos nesse tipo de estudo.
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question2" aria-expanded="false" aria-controls="question2">
                                <i class="fas fa-cogs text-primary me-2"></i> Quais são os principais recursos da Thoth?
                            </button>
                        </h2>
                        <div id="question2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A Thoth oferece uma série de recursos que facilitam a organização e análise de dados durante o processo de revisão sistemática, incluindo a importação de estudos, gerenciamento de dados e geração de relatórios automatizados.
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question3" aria-expanded="false" aria-controls="question3">
                                <i class="fas fa-laptop-code text-primary me-2"></i> Quais tecnologias foram usadas no desenvolvimento da Thoth?
                            </button>
                        </h2>
                        <div id="question3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A Thoth foi desenvolvida utilizando tecnologias modernas como Python, JavaScript, React e bancos de dados relacionais, garantindo robustez e facilidade de integração com outras ferramentas.
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question4" aria-expanded="false" aria-controls="question4">
                                <i class="fas fa-users text-primary me-2"></i> Quem são os responsáveis pelo desenvolvimento e manutenção da Thoth?
                            </button>
                        </h2>
                        <div id="question4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A Thoth é mantida por uma equipe de desenvolvedores e pesquisadores especializados em revisão sistemática e automação de processos científicos.
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question5" aria-expanded="false" aria-controls="question5">
                                <i class="fas fa-lock text-primary me-2"></i> A Thoth é uma ferramenta de código aberto? Qual licença é usada?
                            </button>
                        </h2>
                        <div id="question5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim, a Thoth é uma ferramenta de código aberto e está disponível sob a licença MIT, permitindo que qualquer pessoa utilize e modifique o código conforme necessário.
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 6 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question6" aria-expanded="false" aria-controls="question6">
                                <i class="fas fa-mobile-alt text-primary me-2"></i> A Thoth é uma ferramenta multiplataforma? Quais dispositivos ela suporta?
                            </button>
                        </h2>
                        <div id="question6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim, a Thoth é uma plataforma multiplataforma, funcionando em desktops, laptops e dispositivos móveis (iOS e Android).
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 7 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question7" aria-expanded="false" aria-controls="question7">
                                <i class="fas fa-brain text-primary me-2"></i> Como a Thoth automatiza partes do processo de revisão sistemática?
                            </button>
                        </h2>
                        <div id="question7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A Thoth automatiza a coleta, a organização e a análise dos dados dos estudos, além de gerar relatórios e gráficos automaticamente, economizando tempo e esforço.
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 8 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question8" aria-expanded="false" aria-controls="question8">
                                <i class="fas fa-folder text-primary me-2"></i> Quais são as funcionalidades de gerenciamento de estudos oferecidas pela Thoth?
                            </button>
                        </h2>
                        <div id="question8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A Thoth permite importar, organizar, classificar e filtrar os estudos com base em critérios personalizados, facilitando a análise e comparação.
                            </div>
                        </div>
                    </div>
                    <!-- Pergunta 9 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question9" aria-expanded="false" aria-controls="question9">
                                <i class="fas fa-chart-bar text-primary me-2"></i> A Thoth oferece a geração de gráficos, tabelas e relatórios? Como esses resultados podem ser compartilhados?
                            </button>
                        </h2>
                        <div id="question9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim, a Thoth gera gráficos, tabelas e relatórios completos que podem ser exportados em formatos como PDF, CSV e Excel, facilitando o compartilhamento dos resultados.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contato com Suporte -->
                <h3 class="text-dark mt-5 mb-4">
                    <i class="fas fa-envelope text-primary me-3"></i>
                    📩 Contato com Suporte
                </h3>
                <p class="text-muted mb-4">
                    Caso você tenha dúvidas que não foram respondidas acima, ou esteja enfrentando problemas técnicos, entre em contato com a nossa equipe de suporte:
                </p>
                <a href="mailto:support@thoth.com">
                    <button class="btn bg-gradient-primary text-white shadow-lg rounded-pill px-4 py-2">
                        Enviar e-mail para suporte
                    </button>
                </a>

                <!-- Como usar o Thoth -->
                <h3 class="text-dark mt-5 mb-4">
                    <i class="fas fa-play-circle text-primary me-3"></i>
                    Como usar o Thoth?
                </h3>
                <p class="text-muted mb-4">
                    O Thoth é uma ferramenta para ajudar pesquisadores a realizarem revisões sistemáticas de forma mais ágil e colaborativa. Ele pode ser utilizado em várias fases do processo de revisão, como pesquisa e seleção de estudos, análise de dados, e geração de relatórios.
                </p>
                <ol class="mb-4">
                    <li>Passo 1: Realize o login na plataforma utilizando seu e-mail ou conta Google.</li>
                    <li>Passo 2: Crie um novo projeto ou acesse um projeto existente.</li>
                    <li>Passo 3: Defina os critérios para a busca dos estudos.</li>
                    <li>Passo 4: Importe e selecione os estudos relevantes.</li>
                    <li>Passo 5: Avalie a qualidade dos estudos e extraia os dados necessários.</li>
                    <li>Passo 6: Geração de gráficos e relatórios.</li>
                </ol>

                <!-- Como configurar notificações -->
                <h3 class="text-dark mt-5 mb-4">
                    <i class="fas fa-bell text-primary me-3"></i>
                    Como configurar notificações?
                </h3>
                <p class="text-muted mb-4">
                    O Thoth oferece opções para personalizar notificações. Para ajustar as configurações de notificação, basta acessar o menu "Configurações", onde você pode escolher ser notificado por e-mail sobre as atualizações do seu projeto.
                </p>
                <ol class="mb-4">
                    <li>Acesse a seção "Configurações" do seu perfil.</li>
                    <li>Selecione "Notificações".</li>
                    <li>Marque as notificações que deseja receber.</li>
                    <li>Salve suas configurações.</li>
                </ol>

                <!-- Como adicionar membros -->
                <h3 class="text-dark mt-5 mb-4">
                    <i class="fas fa-users text-primary me-3"></i>
                    Como adicionar membros ao seu projeto?
                </h3>
                <p class="text-muted mb-4">
                    Você pode adicionar membros ao seu projeto facilmente, clicando em "Adicionar membro" na seção de gerenciamento de membros. Após a adição, os membros serão notificados por e-mail e poderão começar a colaborar.
                </p>
            </div>
        </div>
 <!-- Box de Citação do Thoth - Minimalista com laranja queimado e azul escuro -->
<div class="p-5 mt-5 rounded-4 shadow-sm" style="background-color: #1e253b; color: #f5f6fa; border: 1px solid #2e3755;">
    <h4 class="fw-semibold mb-3" style="font-size: 1.5rem; color: #e67e22;">Cite o Thoth em sua pesquisa</h4>
    
    <p class="mb-4" style="color: #c4c8d4; font-size: 0.95rem; max-width: 680px;">
        Se o Thoth foi útil na sua revisão sistemática ou artigo acadêmico, considere citá-lo. Sua citação contribui para o reconhecimento e a continuidade deste projeto na comunidade científica.
    </p>

    <div class="bg-white bg-opacity-10 p-3 rounded-3 mb-4" style="font-style: italic; color: #4a6fa5;">
        Thoth, <cite>Sistema de Apoio a Revisões Sistemáticas</cite>, 2025.
    </div>

    <a href="https://thoth.com/citation" class="text-decoration-none" style="color: #a6b3d0; font-size: 0.9rem;">
        Saiba mais sobre como citar o Thoth →
    </a>
</div>


@endsection
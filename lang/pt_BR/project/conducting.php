<?php

return [
    'conducting' => [
        'title' => 'Condução'
    ],
    'header' => [
        'overview' => 'Visão Geral',
        'import_studies' => 'Importar Estudos',
        'study_selection' => 'Seleção de Estudos',
        'quality_assessment' => 'Avaliação de Qualidade',
        'snowballing' => 'Estudos Snowballing',
        'data_extraction' => 'Extração de Dados',
    ],
    'check' => [
        'domain' => '<li>Cadastre os dados de "Domínio" para este projeto de revisão.</li>',
        'language' => '<li>Cadastre os dados de "Linguagem" para este projeto de revisão.</li>',
        'study-types' => '<li>Cadastre os dados de "Tipos de Estudo" para este projeto de revisão.</li>',
        'research-questions' => '<li>Cadastre os dados de "Questões de Pesquisa" para este projeto de revisão.</li>',
        'databases' => '<li>Cadastre os dados de "Base de Dados" para este projeto de revisão.</li>',
        'term' => '<li>Cadastre os dados de "Termos de busca" na String de Busca para este projeto de revisão.</li>',
        'search-strategy' => '<li>Cadastre os dados de "Estratégia de busca" para este projeto de revisão.</li>',
        'criteria' => '<li>Cadastre os dados de "Critérios de Inclusão ou Exclusão" para este projeto de revisão.</li>',
        'general-score' => '<li>Cadastre os dados de "Pontuação Geral/Intervalos" na Avaliação de Qualidade para este projeto de revisão.</li>',
        'cutoff' => '<li>Cadastre os dados de "Pontuação Mínima para Aprovação" ou complete a "pontuação geral" para este projeto de revisão.</li>',
        'score-min' => '<li>Defina a "Pontuação de Qualidade Mínima para Aprovação" nas perguntas deste projeto de revisão.</li>',
        'question-qa' => '<li>Cadastre as "Questões de Qualidade" ou defina a "Pontuação Mínima para Aprovação" para este projeto de revisão.</li>',
        'score-qa' => '<li>Cadastre os dados de "Pontuação de Qualidade" para este projeto de revisão.</li>',
        'data-extraction' => '<li>Cadastre as "Questões de Extração de Dados" para este projeto de revisão.</li>',
        'option-extraction' => '<li>Cadastre as "Opções" das questões de extração de dados para este projeto de revisão.</li>',
        'mismatch-weight-general-score' =>'<li>A soma dos pesos das Questões de Qualidade não corresponde ao valor máximo do último intervalo em "Intervalos de Pontuação Geral". <br>Verifique e gere novamente os intervalos no módulo de Planejamento.</li>',
    ],
    'protocol_warning' => [
        'title'   => 'Atenção antes de iniciar a Condução',
        'message' => '
            <p class="fw-semibold text-dark">
                <span class="badge bg-warning text-dark">
                    <i class="fa-solid fa-exclamation-circle me-1"></i> Aviso Importante
                </span><br><br>
                Caro usuário da <strong>Thoth</strong>, antes de iniciar a <strong>etapa de Condução</strong> do seu estudo,
                é fundamental garantir que o seu <strong>protocolo e planejamento</strong> estejam totalmente revisados e consolidados.
            </p>

            <ul class="text-muted ms-3">
                <li>Revise os <strong>critérios de inclusão/exclusão</strong>.</li>
                <li>Verifique as <strong>questões de qualidade</strong> e os <strong>itens de extração de dados</strong>.</li>
                <li>Confirme que todas as decisões metodológicas estão bem definidas.</li>
            </ul>

            <p class="mt-3">
                <span class="badge bg-danger">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Atenção
                </span>
                Alterações futuras nessas etapas podem <strong>interferir nos resultados já processados</strong>.
                Caso isso ocorra, você precisará <u>refazer manualmente</u> as avaliações afetadas.
            </p>

            <div class="alert alert-warning mt-3" role="alert">
                <i class="fa-solid fa-lightbulb me-1"></i>
                <strong>Dica:</strong> Revise seu protocolo com cuidado antes de prosseguir para evitar retrabalhos.
            </div>
        ',
        'confirm' => 'Estou Ciente',
        'cancel'  => 'Cancelar',
    ],
    'study-selection' => [
        'title' => 'Seleção de Estudos',
        'help' => [
            'content' => 'A seleção de estudos é uma fase crucial da revisão sistemática, na qual o autor analisa o título, resumo e palavras-chave de cada estudo, avaliando-os conforme as regras dos critérios de inclusão e exclusão estabelecidos no planejamento da revisão. Com base nesses critérios, o status de cada estudo será automaticamente alterado. No entanto, o pesquisador tem a opção de definir o status manualmente, mas, ao fazer isso, o sistema não registrará quais critérios foram considerados na avaliação.
            <br/><br/>
            <h6>Atualizar Dados Faltantes dos Estudos</h6>
        <p>Antes de iniciar a etapa de identificação de duplicados, é recomendável atualizar os metadados dos papers que estejam com informações incompletas:</p>
        <ul>
            <li><b>1 – Via CrossRef e SpringerLink:</b> é necessário que o paper possua um <b>DOI</b>. Caso as informações sejam encontradas, o sistema irá preencher automaticamente os campos ausentes e atualizar o registro do paper.</li>
            <li><b>2 – Via Semantic Scholar:</b> a busca pode ser feita tanto por <b>Título</b> quanto por <b>DOI</b>. O sistema atualizará os dados faltantes (título, autores, resumo, palavras-chave, etc.) se as informações forem encontradas na base.</li>
        </ul>
            <br/>
            <h6>Encontrar Duplicados</h6>
            <p>Temos duas opções para assinalar os papers como duplicados: </p>
            <ul><li>1- Os estudos com as informações  de "Título, Ano e Autores" podem ser assinalados como duplicados todos de uma vez; </li>
            <li>2- Os estudos com apenas alguma informação parecida, pode ser analisada individualmente. </li></ul>
            <h6>Avaliação por Pares (Decisão em grupo)</h6>
            <p>Caso realize a avaliação com 2 ou mais pesquisadores, e <b>haja alguma discordância</b> no resultado da mesma, irão aparecer as seguintes informações na tela:</p>
            <ul><li><div class="badge bg-warning text-white" role="button" title="Resolver Conflitos">
                <i class="fa-solid fa-file-circle-exclamation"></i> Resolver
            </div> | Será necessário tomar uma decisão final em grupo.</li>
            <li><div class="badge bg-light text-dark" role="button"  title="Conflitos Resolvidos">
                <i class="fa-solid fa-check-circle"></i> OK
            </div>| Decisão em grupo já confirmada.</li></ul>
            <p>Obs.: Se a revisão não conter Avaliação por Pares, estas opções não irão aparecer.</p>
            '
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum Paper foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'acceptance-criteria' => 'Critério de Aceitação',
            'rejection-criteria' => 'Critério de Rejeição',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todos as Bases',
            'select-status' => 'Mostrar todos Status...',
            'search-papers' => 'Buscar estudos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-selection' => 'Status da Seleção',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'paper-conflict'=>'Resolver Conflitos: Decisão em Grupo - Critério de I/E',
            'paper-conflict-note'=>'Nota/Justificativa',
            'paper-conflict-writer'=>'Escreva sua nota/justificativa...',
            'success-decision'=>'Decisão em Grupo salva com sucesso.',
            'error-status'=>'Selecione sua Decisão Final',
            'last-confirmation' => 'Confirmado por',
            'confirmation-date' => 'em',
            'save-criterias' => 'Salvar/Aplicar Critérios',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
                'inclusion' => 'Inclusão',
                'exclusion' => 'Exclusão',
                'conflicts-members' => 'Avaliação do Membro',
                'conflicts-criteria' => 'Critério I/E Selecionado',
                'conflicts-status' => 'Status da avaliação',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Unclassified',
                'final-decision' => 'Decisão final do grupo sobre o paper?',
            ],
            'buttons' => [
                'crossref' => [
                    'error_missing_data' => 'É necessário informar o DOI ou o título do paper para buscar dados via CrossRef.',
                    'success' => 'A atualização dos dados foi solicitada via CrossRef. Verifique se as informações foram atualizadas.',
                ],
                'springer' => [
                    'error_missing_doi' => 'É necessário informar o DOI para buscar dados via Springer.',
                    'success' => 'A atualização dos dados foi solicitada via Springer. Verifique se as informações foram atualizadas.',
                ],
                'semantic' => [
                    'error_missing_query' => 'É necessário informar o DOI ou o título para buscar dados via Semantic Scholar.',
                    'failed' => 'Erro ao tentar atualizar via Semantic Scholar. Tente novamente mais tarde.',
                    'success' => 'A atualização dos dados foi solicitada via Semantic Scholar. Verifique se as informações foram atualizadas.',
                ],
            ],
            'update_via' => 'Atualizar via:',
            'save' => 'Salvar',
            'update' => 'Atualizar',
            'confirm' => 'Confirmar',
            'close' => 'Fechar',
            'error' => 'Erro',
            'success' => 'Sucesso',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum paper importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ],
        ],
        'duplicates' => [
            'title' => 'Revisão de papers Duplicados',
            'no-duplicates' => 'Não foram encontrados papers Duplicados.',
            'confirm-duplicate' => 'Paper marcado como duplicado.',
            'erro-find-paper' => 'Erro: Paper não encontrado.',
            'marked-unclassified' => 'Paper marcado como não classificado.',
            'analyse-all' => 'Todos os papers Duplicados foram analisados.',
            'duplicates-all' => "Todos os papers com Autor/Ano/Titulo iguais marcados como Duplicados",
            'unique-papers' => 'papers possivelmente duplicados para análise individual listados abaixo. ',
            'exact-duplicate-count' => 'papers com <b>Título/Ano/Autores</b> exatamente idênticos como duplicados.',
            'button-mark-all' => 'Marcar os :count como Duplicados',
            'table-title' => 'Título',
            'table-year' => 'Ano',
            'table-database' => 'Base de Dados',
            'table-duplicate' => 'Duplicado',
            'table-duplicate-yes' => 'SIM',
            'table-duplicate-no' => 'NÃO',
            'success-message' => 'Paper Duplicado atualizado com sucesso!',
        ],
        'messages' => [
            'criteria_updated' => 'Critério atualizado com sucesso. Novo status: :status',
        ],
        'toasts' => [
            'denied' => 'Um visualizador não pode editar a seleção de estudos',
        ]
    ],
    'snowballing' => [
        'title' => 'Snowballing',
        'help' => [
            'content' => 'Snowballing consiste em localizar e incorporar novos estudos a partir de referências e citações do artigo semente (paper base). É útil para encontrar evidências que não emergem da busca convencional e é amplamente recomendado em revisões sistemáticas.

<br><br>
<h6>Como usar o módulo no sistema</h6>
<ol>
  <li><b>Abrir o modal do paper</b>: na lista de estudos, clique no paper desejado para abrir o modal de Snowballing.</li>
  <li><b>Verificar metadados</b>: confira autor, ano, base de dados, DOI/URL e use os atalhos (DOI, URL, Scholar) se necessário.</li>
  <li><b>Escolher o modo de execução</b>:
    <ul>
      <li><b>Snowballing Manual</b> (nível único):
        <ul>
          <li>Selecione <b>Backward</b> para buscar apenas as <i>referências citadas</i> pelo paper.</li>
          <li>Selecione <b>Forward</b> para buscar apenas as <i>citações recebidas</i> pelo paper.</li>
          <li>O sistema salva apenas o <b>nível 1</b> (sem iteração). Ideal quando você quer total controle.</li>
          <li><b>Importante</b>: ao executar o modo manual para este paper (Backward e/ou Forward), o <b>modo automatizado fica desabilitado</b> para este mesmo paper.</li>
        </ul>
      </li>
      <li><b>Snowballing Automatizado</b> (iterativo):
        <ul>
          <li>Executa <b>apenas o que falta</b> (Backward e/ou Forward) para o paper semente.</li>
          <li>Para cada nova referência/citação com DOI encontrada, o sistema <b>itera</b> automaticamente (nível 2, 3, ...) até <b>não haver mais novos itens</b>.</li>
          <li>Use este modo quando você precisa de uma exploração completa e encadeada do conjunto de estudos.</li>
        </ul>
      </li>
    </ul>
  </li>
  <li><b>Acompanhar resultados</b>:
    <ul>
      <li>A tabela exibe <b>Título</b> (com quebra de linha), <b>Autores</b>, <b>Tipo</b> (Backward/Forward), <b>Ano</b>, <b>Score</b>, <b>Ocorrências</b>, <b>Fonte</b> e <b>Relevante?</b>.</li>
      <li>Você pode <b>marcar/reverter</b> a relevância com o botão de alternância. Essa marca fica vinculada ao <b>paper semente</b> e aparece sempre que abrir o modal.</li>
    </ul>
  </li>
</ol>

<br>
<h6>O que é Backward e Forward?</h6>
<ul>
  <li><b>Backward</b>: examina as <b>referências</b> listadas pelo paper base (o que ele citou).</li>
  <li><b>Forward</b>: encontra estudos que <b>citam</b> o paper base (quem o citou).</li>
</ul>

<br>
<h6>Fontes de dados</h6>
<ul>
  <li><b>CrossRef</b>: referências (Backward) via <code>/works/{doi}</code> e citações (Forward) via <code>/works/{doi}/cited-by</code>.</li>
  <li><b>Semantic Scholar</b>: usado como <i>fallback</i> para completar Backward e Forward quando necessário.</li>
</ul>

<br>
<h6>Como o sistema calcula relevância e similaridade</h6>
<p>A cada referência encontrada, o sistema avalia automaticamente sua <b>similaridade</b> com o paper base e atribui um <b>score de relevância</b> composto.</p>

<ul>
  <li><b>Similaridade</b>:
    <ul>
      <li>Comparação entre <i>título</i> e <i>resumo</i> do estudo candidato e do paper semente.</li>
      <li>Os textos são normalizados (sem acentuação/pontuação) e comparados por sobreposição de termos.</li>
      <li>A similaridade total é ponderada: 70% título + 30% resumo, resultando em um valor entre 0 e 1.</li>
    </ul>
  </li>
  <li><b>Relevância</b>:
    <ul>
      <li>Composta por três fatores:
        <ul>
          <li>70% = similaridade com o paper semente;</li>
          <li>20% = confiabilidade da fonte (CrossRef = 1.0, Semantic Scholar = 0.8);</li>
          <li>10% = ocorrência (quantas vezes o mesmo DOI foi encontrado em diferentes iterações).</li>
        </ul>
      </li>
      <li>O cálculo segue a fórmula aproximada:<br>
        <code>relevance_score = 0.7 * similarity + 0.2 * source_weight + 0.1 * log(1 + duplicate_count)</code>
      </li>
      <li>Quanto maior o valor, mais relevante o estudo tende a ser em relação ao paper semente.</li>
    </ul>
  </li>
  <li><b>Ocorrências</b>:
    <ul>
      <li>Indicam quantas vezes o mesmo estudo apareceu em diferentes buscas ou iterações.</li>
      <li>O sistema soma as ocorrências e recalcula a média do <b>relevance_score</b> quando o item é encontrado novamente.</li>
    </ul>
  </li>
  <li><b>Relevância manual</b>:
    <ul>
      <li>Além do cálculo automático, o usuário pode marcar um estudo como <b>Relevante?</b> diretamente na tabela.</li>
      <li>Essa marcação manual é permanente e usada em relatórios e visualizações em árvore.</li>
    </ul>
  </li>
</ul>
<br>
<h6>Regras importantes</h6>
<ul>
  <li>Se você rodar <b>Manual</b> para um paper (Backward e/ou Forward), o <b>Automatizado</b> fica indisponível para esse paper.</li>
  <li>No modo automatizado, o sistema só busca o que <b>ainda não foi processado</b> (Backward/Forward).</li>
  <li>Duplicatas são unificadas, somando <b>Ocorrências</b> e mesclando <b>Fontes</b> (por ex.: “CrossRef; SemanticScholar”).</li>
</ul>

<br>
<p><i class="fa-solid fa-users"></i> Se houver Avaliação por Pares na revisão, o ícone acima indica que o paper foi aceito na etapa anterior.</p>'
        ],

        'tasks' => 'Complete essas tarefas para avançar',

        'papers' => [
            'empty' => 'Nenhum artigo foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],

        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'year' => 'Ano',
            'references-found' => 'Referências Encontradas',
            'backward' => 'Backward',
            'forward' => 'Forward',
            'type' => 'Tipo',
            'score' => 'Pontuação',
            'occurrences' => 'Ocorr.',
            'source' => 'Fonte',
            'relevant' => 'Relevante?',
            'unknown-title' => 'Título desconhecido',
            'none' => '-',
        ],

        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todas as Bases de Dados',
            'select-status' => 'Mostrar todos os Status...',
            'select-type' => 'Mostrar todos os Tipos...',
            'search-papers' => 'Pesquisar artigos...',
            'no-papers' => 'Não há estudos disponíveis para exportar',
            'doi' => 'DOI',
            'url' => 'URL',
            'scholar' => 'Scholar',
            'lock' => 'Bloqueado',
            'automated' => 'Snowballing Automatizado',
            'automated-unavailable' => 'Snowballing Automatizado Indisponível',
            'manual' => 'Snowballing Manual',
            'view-paper'=>'Ver Paper/Referência',
        ],

        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-snowballing' => 'Status Snowballing',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'manual-title' => 'Snowballing Manual',
            'manual-select' => 'Selecione...',
            'manual-backward' => 'Backward',
            'manual-forward' => 'Forward',
            'manual-processed' => '(já processado)',
            'manual-readonly' => 'Somente leitura',
            'automated-title' => 'Snowballing Automatizado',
            'automated-or' => 'ou',
            'processing' => 'Processando Snowballing...',
            'close' => 'Fechar',
            'info' => 'Informação',
            'ok' => 'OK',
            'progress-note' => 'Aguarde, estamos analisando as citações.',
        ],

        'messages' => [
            'doi_missing' => 'DOI não encontrado para este paper.',
            'backward_done' => 'Referências backward já foram processadas.',
            'forward_done' => 'Citações forward já foram processadas.',
            'manual_done' => ':type processado manualmente com sucesso!',
            'manual_disabled' => 'Snowballing manual já realizado — modo automático desativado.',
            'automatic_complete' => 'Snowballing completo processado com sucesso!',
            'already_complete' => 'Snowballing já completo para este paper.',
            'missing_paper' => 'DOI ou paper base ausente.',
            'error' => 'Erro: :message',
            'relevance_updated' => 'Relevância atualizada com sucesso!',
            'manual_job_started' => 'Snowballing manual (:type) iniciado com sucesso. Aguarde o processamento.',
            'already_running' => 'Já existe um snowballing em andamento para este estudo.',
            'manual_processing_start' => 'O snowballing manual foi iniciado. Processando referências...',
            'manual_processing_step'  => 'Processando referência :current de :total...',
            'manual_complete'         => 'Snowballing manual concluído com sucesso.',

        ],

        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito',
            'processed' => 'Processado',
            'pending' => 'Pendente',
            'error' => 'Erro',
            'relevant'=>'Referências Relevantes',
            'todo'=>"Não Iniciado",
            'to do'=>"Não Iniciado",
            'done'=>'Finalizado/Processado',
        ],

        'references'=>[
            'relevant'=>'Referências Assinaladas como Relevantes',
            'relevant-children' => 'Referências derivadas deste estudo',
            'none' => 'Nenhuma referência relevante encontrada.',
        ],

        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum artigo importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso.',
            ],
        ],
    ],



    'progress_bar' => [
        'title' => 'Progresso de Extração de Dados',
        'progress_title' => 'Progresso'
    ],

    'search' => [
        'title' => 'Pesquisa',
        'placeholder' => 'Selecione um Estudo',
        'add' => 'Add Novo Estudo',
        'help' => [
            'title' => 'Pesquisa',
            'content' => '',
        ],
    ],

    'table' => [
        'id' => 'ID',
        'title' => 'Titulo',
        'author' => 'Autor',
        'year' => 'Ano',
        'data_base' => 'Banco de Dados',
        'status' => 'Status',
    ],

    'status_extraction' => [
        'title' => 'Status da Extração',
        'no_extraction' => 'Não Extraido',
        'extracted' => 'Extraido',
        'removed' => 'Removido',
    ],

    'feedback' => [
        'done' => 'Status atualizado para Done.',
        'removed' => 'Estudo removido com sucesso.',
    ],

    'questions_table' => [
        'title' => 'Detalhes do Estudo',
    ],

    'import-studies' => [
        'title' => 'Importar estudos',
        'bib_file' => 'Apenas arquivos .bib, .txt (formato BIB) e .csv são permitidos.',
        'form' => [
            'database' => 'Base de dados',
            'selected-database' => 'Selecionar a base de dados',
            'upload' => 'Escolher arquivo',
            'add' =>  'Adicionar arquivo',
            'delete' => 'Deletar'
        ],
        'help' => [
            'content' => 'Insira Arquivos no Formato ".bib", ".txt (formato BibTex) ou ".csv" e faça a importação de arquivos de acordo com a base inserida no planejamento<br>
                     <ul>
                     <li><b>Obs.:</b> Se você deseja realizar <b>"Avaliação por Pares"</b>, é necessário convidar os pesquisadores  e adicionar ao projeto antes de importar os estudos (papers)</li>
                     <li>Para adicionar pesquisadores, navegue até <b>"Meus Projetos->Colaboradores"</b></li>
                     </ul>
                     <br>
                     <b>Orientações para o formato CSV (Springer Link):</b><br>
                     O arquivo CSV deve conter os seguintes cabeçalhos de coluna:<br>
                     <ul>
                         <li>"<b>Item Title</b>" – usado como o título do estudo</li>
                         <li>"<b>Authors</b>" – lista de autores</li>
                         <li>"Item DOI" – identificador digital do objeto</li>
                         <li>"URL" – link opcional para o estudo</li>
                         <li>"Publication Year" – ano de publicação</li>
                         <li>"Book Series Title" – nome da série de livros</li>
                         <li>"Journal Volume" – volume do periódico</li>
                         <li>"Publication Title" – nome do periódico ou publicação</li>
                     </ul>
                     <b>Atenção:</b> Se algum dos campos em <b>negrito</b> estiver ausente ou vazio, a importação <b>não será realizada</b>.'
        ],
        'table' => [
            'database' => 'Base de dados',

            'studies-imported' => 'Estudos importados',
            'actions' => 'Ações',
            'file' => 'Arquivo',
            'files-uploaded' => 'Arquivos carregados',
            'no-files' => 'Nenhum arquivo carregado para esta base de dados.',
            'delete' => 'Deletar',
        ],
        'livewire' => [
            'logs' => [
                'database_associated_papers_imported' => 'Papers associados à base de dados importados',
                'deleted_file_and_papers' => 'Arquivo e :count papers associados excluídos',
            ],
            'selectedDatabase' => [
                'value' => [
                    'required' => 'O campo da base de dados é obrigatório.',
                    'exists' => 'A base de dados selecionada não existe.',
                ],
            ],
            'file' => [
                'required' => 'O campo de descrição é obrigatório.',
                'mimes' => 'O arquivo deve ser do tipo: bib, csv, txt.',
                'max' => 'O tamanho do arquivo não deve exceder 10MB.',
            ],
            'toasts' => [
                'file_uploaded_success' => 'Arquivo carregado com sucesso. Papers foram inseridos e o total será atualizado em instantes em tela.',
                'file_upload_error' => 'Ocorreu um erro ao importar papers. ERRO: :message',
                'project_database_not_found' => 'Base de dados do projeto não encontrada.',
                'file_deleted_success' => 'Arquivo excluído com sucesso. :count papers associados também foram excluídos.',
                'file_delete_error' => 'Ocorreu um erro ao excluir o arquivo: :message',
                'file_already_exists' => 'Um arquivo com este nome já foi adicionado nesta Base de Dados. Evite duplicações!',
                'denied' => 'Um visualizador não pode adicionar ou excluir papers.',
            ],
        ],

    ],

    'quality-assessment' => [
        'title' => 'Avaliação de Qualidade',
        'help' => [
            'content' => 'A Avaliação de Qualidade é uma fase importante, nessa etapa os pesquisadores deverão ler o estudo completo e responder as questões de qualidade que foram
                   planejadas para esta revisão. De acordo com as respostas assinaladas, a "Pontuação, Score Geral e o Status" desta avaliação são atualizados.
            <br/><br/>
            <h6>Avaliação por Pares (Decisão em grupo)</h6>
            <p>Caso realize a avaliação com 2 ou mais pesquisadores, e <b>haja alguma discordância</b> no resultado da mesma, irão aparecer as seguintes informações na tela:</p>
            <ul><li><div class="badge bg-warning text-white" role="button" title="Resolver Conflitos">
                <i class="fa-solid fa-file-circle-exclamation"></i> Resolver
            </div> | Será necessário tomar uma decisão final em grupo.</li>
            <li><div class="badge bg-light text-dark" role="button"  title="Conflitos Resolvidos">
                <i class="fa-solid fa-check-circle"></i> OK
            </div> | Decisão em grupo já confirmada.</li>
            <li><i class="fa-solid fa-users"></i> | Paper aceito em Avaliação por Pares (Decisão do Grupo) na etapa anterior.</li></ul>
            <p>Obs.: Se a revisão não conter Avaliação por Pares, estas opções não irão aparecer.</p>
            '
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum Paper foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'acceptance-criteria' => 'Critério de Aceitação',
            'rejection-criteria' => 'Critério de Rejeição',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'general-score' => 'Pontuação Geral',
            'score' => 'Pontuação',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todos as Bases',
            'select-status' => 'Mostrar todos Status...',
            'search-papers' => 'Buscar estudos...',
            'no-papers' => 'Não há estudos disponíveis para exportar',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-quality' => 'Status de Qualidade',
            'quality-questions' => 'Questões de Qualidade',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'select-score' => 'Selecione...',
            'quality-score' => 'Pontuação',
            'quality-description' => 'Qualidade',
            'apply-scores' => 'Aplicar/Salvar Pontuação',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'score' => 'Pontuação',
                'min-to-app' => 'Mínimo para<br/> Aprovar',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Não Classificado',
            ],
            'save' => 'Salvar',
            'close' => 'Fechar',
        ],
        'resolve' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-selection' => 'Status da Seleção',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'paper-conflict' => 'Resolver Conflitos: Decisão em Grupo - QA',
            'paper-conflict-note' => 'Nota/Justificativa',
            'paper-conflict-writer' => 'Escreva sua nota/justificativa...',
            'success-decision' => 'Decisão em Grupo salva com sucesso.',
            'resolved-decision' => 'Aceito em Avaliação por Pares (Decisão do Grupo) na etapa anterior.',
            'error-status' => 'Selecione sua Decisão Final',
            'last-confirmation' => 'Confirmado por',
            'confirmation-date' => 'em',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
                'inclusion' => 'Inclusão',
                'exclusion' => 'Exclusão',
                'conflicts-members' => 'Avaliação do Membro',
                'conflicts-qa' => 'Pontuação/ Avaliação Geral',
                'conflicts-status' => 'Status da avaliação',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Unclassified',
                'final-decision' => 'Decisão final do grupo sobre o paper?',
            ],
            'save' => 'Salvar',
            'update' => 'Atualizar',
            'confirm' => 'Confirmar',
            'close' => 'Fechar',
            'error' => 'Erro',
            'success' => 'Sucesso',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum paper importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ],
        ],
        'messages' => [
            'evaluation_quality_score_updated' => 'Pontuação de Avaliação de Qualidade atualizada com sucesso.',
            'missing_scores' => 'Você deve selecionar uma pontuação para todas as questões antes de aplicar. :count questão(ões) sem resposta.',
            'status_quality_updated' => 'Status de Qualidade atualizado com sucesso. Novo status: :status',
            'status_updated_for_selection' => 'Status atualizado para sua seleção. Novo status: :status',
        ],
    ],

    'data-extraction' => [
        'title' => 'Extração de Dados',
        'help' => [
            'content' => 'A Extração de Dados é a última fase da revisão. Nessa etapa os pesquisadores após ler o estudo completo, deverão extrair as informações
                  que respondam as questões de extração planejadas. Após a concluída é necessário assinalar a extração como finalizada, para cada estudo,
                  para assim estas informações constarem nos relatórios existentes.
            <br/><br/>
            <h6>Avaliação por Pares (Decisão em grupo)</h6>
            <p>Caso realize a avaliação com 2 ou mais pesquisadores, e <b>haja alguma discordância</b> no resultado da mesma, irão aparecer as seguintes informações na tela:</p>
            <ul><li><i class="fa-solid fa-users"></i> | Paper aceito em Avaliação por Pares (Decisão do Grupo) na etapa anterior.</li></ul>
            <p>Obs.: Se a revisão não conter Avaliação por Pares, este ícone não irá aparecer.</p>
            '
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum artigo foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'year' => 'Ano',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todas as Bases de Dados',
            'select-status' => 'Mostrar todos os Status...',
            'search-papers' => 'Pesquisar artigos...',
            'no-papers' => 'Não há estudos disponíveis para exportar',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-extraction' => 'Status da Extração',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'removed' => 'Remover',
                'done' => 'Concluído',
                'to_do' => 'A fazer',
                'to do' => 'A fazer',
                'unclassified' => 'Não Classificado',
            ],
            'save' => 'Salvar',
            'close' => 'Fechar',
        ],
        'status' => [
            'done' => 'Concluído',
            'removed' => 'Removido',
            'to do' => 'A Fazer',
            'to_do' => 'A Fazer',
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum artigo importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ]
        ]
    ],


];

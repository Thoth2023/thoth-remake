<?php

return [

    'reporting' => 'Relatórios',
    'content-helper' => '
        <p>O módulo de <strong>Relatórios</strong> reúne todas as informações geradas ao longo da sua Revisão Sistemática ou Mapeamento Sistemático.
        Nesta área, você pode visualizar gráficos, tabelas, contagens e estatísticas que representam o progresso e os resultados da revisão.</p>

        <h5><strong>Como utilizar os relatórios?</strong></h5>
        <ul>
            <li><strong>Visualização:</strong> explore gráficos que representam cada etapa da revisão — Importação, Seleção, Qualidade, Snowballing e Extração de Dados.</li>
            <li><strong>Acompanhamento:</strong> veja o funil de estudos, números de aceitos, rejeitados, duplicados, removidos e demais métricas relevantes.</li>
            <li><strong>Conferência:</strong> valide rapidamente se todas as etapas foram concluídas e identifique possíveis inconsistências.</li>
        </ul>

        <h5><strong>Exportação de Dados</strong></h5>
        <p>Você pode exportar tabelas e resultados nos formatos mais comuns utilizados em pesquisas:</p>
        <ul>
            <li><strong>CSV:</strong> para manipular em Excel, Google Sheets ou scripts estatísticos.</li>
            <li><strong>XML:</strong> ideal para intercâmbio de dados ou automações personalizadas.</li>
            <li><strong>PDF:</strong> excelente para anexar ao relatório da revisão, artigos ou documentos formais.</li>
        </ul>

        <p>O módulo de relatórios foi projetado para ajudar no entendimento global do estudo, facilitar análises quantitativas e
        gerar dados que podem ser diretamente utilizados em artigos científicos, dissertações e relatórios técnicos.</p>
    ',
    'header' => [
        'overview' => 'Visão Geral',
        'reliability' => 'Concordância',
        'import_studies' => 'Importar Estudos',
        'study_selection' => 'Seleção de Estudos',
        'quality_assessment' => 'Avaliação de Qualidade',
        'data_extraction' => 'Extração de Dados',
        'snowballing' => 'Snowballing',
    ],

    'overview'=> [
        'systematic-mapping-study' => [
            'title' => 'Estudo de Mapeamento Sistemático sobre Ferramentas de Desenvolvimento de Linguagem específicas de domínio funil',
            'database' => [
                'title' => 'Banco de Dados',
                'content'=>'Busca em bibliotecas digitais',
            ],
            'imported-studies' => 'Estudos Importados',
            'duplicates' => [
                'title'=> 'Duplicados',
                'content'=>'Duplicados Removidos',
            ],
            'studies' => 'Estudos',
            'study-selection' => [
                'title'=> 'Seleção de Estudos',
                'content'=>'I/E Removidos',
            ],
            'studies-I/E-included'=> 'Estudos I/E Incluídos',
            'quality-assessment' => [
                'title' => 'Avaliação de Qualidade',
                'content'=> 'QA Rejeitados',
            ],
            'studies-accepted' => [
                'title' => '#Extração de Dados Disponível',
                'content'=>'Estudos Aceitos',
            ],
            'not-duplicate' => 'Não Duplicados',
            'status-selection' => 'Seleção de Status',
            'status-quality'=> 'Status de Qualidade',
            'status-extration' => 'Status de Extração',
        ],
        'stages-systematic-review'=>'Etapas da Revisão Sistemática da literatura ou estudo de mapeamento sistemático',
        'project-activities-overtime'=> 'Atividades do projeto ao longo do tempo',
        'total-activities'=> 'Atividades Totais',
        'project'=> 'Projeto',
    ],
    'imported-studies'=> [
        'papers-database'=> [
            'title'=> 'Estudos por Banco de Dados',
            'content'=> 'Estudos',
        ],
        'number-papers-year' => [
            'title'=> 'Número de Estudos por Ano',
            'year'=> 'Ano',
            'number-of-papers'=> 'Número de Estudos',
        ],
    ],
    'study-selection'=> [
        'papers-per-selection' => [
            'title'=> 'Estudos por Status de Seleção',
            'content'=> 'Estudos',
        ],
        'criteria-marked-user'=> [
            'title'=> 'Critérios Assinalados por Usuário',
            'criteria-identified-study-selection' => 'Critérios Assinalados na Seleção de Estudos',
            'number-times' => 'Número de Vezes',
            'criteria' => 'Critério',
            'user' => 'Usuário',
            'value' => 'Valor',
        ],
        'number-papers-user-status-selection' => [
            'title'=> 'Número de Estudos por Usuário e Status de Seleção',
            'users' => 'Usuários',
            'number-papers' => 'Número de Estudos',
            'accepted'=> 'Aceitos',
        ],
    ],
    'quality-assessment'=> [
        'papers-status-quality'=> [
            'title'=> 'Estudos por Status de Qualidade',
            'content'=> 'Estudos',
        ],
        'papers-general-score'=> [
            'title'=> 'Estudos por Pontuação Geral',
            'content'=> 'Estudos',
        ],
        'number-papers-user-status-quality'=> [
            'title' => 'Número de Estudos por Usuário e Status de Qualidade',
            'users'=> 'Usuários',
            'number-papers' => 'Número de Estudos',
        ]
    ],

    'data-extraction'=> [
        'data-extraction-wordcloud'=> 'Nuvem de Palavras da Extração de Dados',
        'data-extraction-answer-packed-bubble'=> 'Respostas de Extração de Dados - Packed Bubble',
        'comparasion-answers-question'=> [
            'title'=> 'Comparação de Respostas por Questão',
            'content'=> 'Respostas',
        ]
    ],

    'reliability' =>[
        'selection' =>[
            'title' => 'Seleção de Estudos',
            'content' => '
        <p>O relatório de <strong>Avaliação por Pares na Seleção de Estudos</strong> permite comparar as classificações feitas por dois pesquisadores sobre cada estudo importado para a revisão.</p>

        <h5><strong>Como funciona?</strong></h5>
        <ul>
            <li>Cada pesquisador classifica os estudos de forma independente, aplicando os critérios de inclusão e exclusão.</li>
            <li>O sistema registra a decisão de cada avaliador: Aceito, Rejeitado, Não Classificado, Removido ou Duplicado.</li>
            <li>O relatório exibe lado a lado as decisões do Pesquisador #1 e do Pesquisador #2.</li>
            <li>Uma coluna adicional mostra o resultado da <strong>avaliação por pares</strong>, consolidando ou destacando divergências.</li>
        </ul>

        <h5><strong>Métricas de Confiabilidade</strong></h5>
        <p>O relatório também apresenta gráficos de:</p>
        <ul>
            <li><strong>Concordância Simples:</strong> mostra o percentual de estudos em que os avaliadores tomaram a mesma decisão.</li>
            <li><strong>Método Kappa:</strong> indicador estatístico que considera a concordância além do acaso.</li>
        </ul>

        <h5><strong>Exportação dos Resultados</strong></h5>
        <p>Os dados podem ser exportados em CSV, XML ou PDF para uso em artigos, relatórios ou análises externas.</p>

        <p>Esse módulo ajuda a garantir rigor metodológico e transparência no processo de seleção dos estudos.</p>
    ',
        ],
        'quality'=>[
            'title' => 'Avaliação de Qualidade ',
            'content' => '
        <p>No relatório de <strong>Avaliação por Pares na Avaliação de Qualidade</strong>, você pode comparar como cada pesquisador respondeu às questões de qualidade definidas no planejamento.</p>

        <h5><strong>Como funciona?</strong></h5>
        <ul>
            <li>Cada pesquisador avalia individualmente os estudos aceitos na etapa de seleção.</li>
            <li>As respostas são comparadas entre Pesquisador #1 e Pesquisador #2.</li>
            <li>O relatório destaca concordâncias, divergências e casos que ainda não foram avaliados.</li>
            <li>É possível visualizar também o resultado consolidado (quando aplicável).</li>
        </ul>

        <h5><strong>Métricas de Confiabilidade</strong></h5>
        <ul>
            <li><strong>Concordância Simples:</strong> percentual de respostas iguais entre os revisores.</li>
            <li><strong>Índice Kappa:</strong> avaliação estatística considerando a concordância ao acaso.</li>
        </ul>

        <h5><strong>Exportação</strong></h5>
        <p>Todos os dados podem ser exportados em CSV, XML ou PDF para inclusão no relatório final ou artigo científico.</p>

        <p>Este módulo fornece evidências da confiabilidade da avaliação e fortalece a validade dos resultados da revisão.</p>
    ',
        ],
        'agreement'=>[
            'title' => 'Concordância Simples',
            'content'=>'<p>A <strong>Concordância Simples</strong> (ou "Concordância Bruta") mede a frequência com que dois ou mais pesquisadores (avaliadores) atribuem **exatamente a mesma classificação** (ex: Aceitar ou Rejeitar) a um estudo. É o índice mais direto de quão frequentemente sua equipe concordou.</p>
<h4>Como Funciona no Projeto?</h4>
<p>É calculada como a <strong>porcentagem de decisões idênticas</strong> em relação ao número total de artigos avaliados. Por exemplo, se em 10 estudos, os pesquisadores concordaram em 8, a concordância é de 80%.</p>
<h4>⚠️ Atenção</h4>
<p>Embora seja simples, esta métrica <strong>não considera a concordância que ocorre por puro acaso</strong> (sorte). Por isso, seu valor tende a ser <strong>inflacionado</strong> (mais alto do que a concordância real), e não é a medida mais robusta de confiabilidade.</p>',
            'title-modal' => 'Análise Concordância Simples',
            'agreement-percentual'=> 'Percentual de Concordância (%)',
        ],
        'kappa'=>[
            'title' => 'Método Kappa',
            'content'=>'<p>O <strong>Coeficiente Kappa de Cohen</strong> é uma medida estatística que avalia a concordância entre avaliadores em dados categóricos, mas, crucialmente, **desconta a proporção de concordância que seria esperada pelo acaso**.</p>
<p>É a medida padrão de confiabilidade (ou "confiança") na pesquisa científica. Um Kappa alto indica que a concordância observada é significativamente maior do que a sorte.</p>
<h4>Interpretação do Valor de Kappa</h4>
<p>O valor de Kappa varia de <strong>-1 a 1</strong>, onde 1 é a concordância perfeita.</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Valor de Kappa</th>
            <th>Nível de Concordância</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>0 a 0,20</td><td>Nenhum</td></tr>
        <tr><td>0,21 a 0,39</td><td>Mínima</td></tr>
        <tr><td>0,40 a 0,59</td><td>Fraca</td></tr>
        <tr><td>0,60 a 0,79</td><td><strong>Moderada</strong></td></tr>
        <tr><td>0,80 a 0,90</td><td><strong>Forte</strong></td></tr>
        <tr><td>&gt; 0,90</td><td>Quase Perfeita</td></tr>
    </tbody>
</table>
<small>Referência: Adaptado de McHugh (2012) e Landis & Koch (1977).</small>
<h4>Relevância no Projeto</h4>
<p>Um Kappa baixo (Fraco ou Mínimo) em fases como <strong>Seleção de Estudos</strong> ou <strong>Avaliação de Qualidade</strong> é um alerta! Isso indica que os critérios estão ambíguos ou que há inconsistência na forma como a equipe está aplicando as regras. Nessas situações, a equipe deve se reunir e recalibrar a avaliação.</p>',
            'title-modal' => 'Análise Kappa nas Etapas',
            'kappa-value' => 'Valor de Kappa',
        ],
        'pesquisador'=>'Pesquisador',
        'peer-review'=>'Avaliação por Pares (Revisor)',
    ],
    'snowballing'=>[
        'relevant_papers' => 'papers relevantes incluídos',
        'seed_papers' => '{0} nenhum paper semente|{1} 1 paper semente|[2,*] :count papers sementes',
        'levels' => '{0} nenhum nível|{1} 1 nível|[2,*] :count níveis',
        'legend' => 'Legenda',
        'seed' => 'Paper Semente',
        'forward' => 'Forward',
        'backward' => 'Backward',
        'unknown' => 'Desconhecido',
        'chart_title' => 'Árvore de Iterações do Snowballing',
        'tooltip_type' => 'Tipo',
        'tooltip_relevance' => 'Relevância',
        'no_data' => 'Nenhum dado disponível para gerar o gráfico.',
        'no_chart_data' => 'Não há dados suficientes para o gráfico.',
        'no_title' => 'Sem título',
    ],

    'check' => [
        'no_imported_studies' => 'Nenhum estudo foi importado nesse projeto.',
        'no_selected_studies' => 'Você não selecionou nenhum estudo nesse projeto.',
        'no_criteria_signed_by_anyone' => 'Nenhum critério foi assinado por ninguém.',
        'no_papers_and_status_selection' => 'Ninguém selecionou nenhum estudo nesse projeto.',
        'no_evaluated_studies' => 'Você não avaliou nenhum estudo nesse projeto.',
        'no_papers_evaluated_by_anyone' => 'Ninguém avaliou nenhum estudo nesse projeto.',
        'no_extracted_data_by_anyone' => 'Ninguém extraiu dados nesse projeto.',
        'study-selection'=> 'Seleção de Estudos',
        'quality-assessment'=> 'Avaliação de Qualidade',
    ]
];

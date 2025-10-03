<?php

return [

    'reporting' => 'Relatórios',
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
            'content'=>'',
        ],
        'quality'=>[
            'title' => 'Avaliação de Qualidade ',
            'content'=>'',
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

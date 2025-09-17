<?php

return [
    'title' => 'Busca de Referências e Citações (Snowballing)',
    'modal' => [
        'title' => 'Ajuda sobre a busca de referências (Snowballing)',
        'content' => "
            <p>Este módulo permite realizar a busca de artigos relacionados (referências e citações) a partir de um artigo semente, utilizando a <strong>API do Semantic Scholar</strong>.</p>

            <p><strong>Recomenda-se fortemente a utilização de DOIs</strong> para realizar a busca, pois os endpoints de busca por título da API apresentam limitações técnicas e de taxa de requisição no momento.</p>

            <p>Resultados incluem metadados básicos (título, autores, ano, DOI, URL) e listas de artigos referenciados (backward) e artigos que citam o artigo original (forward).</p>
        ",
    ],
    'input_label' => 'DOI ou Título Exato do Artigo',
    'input_placeholder' => 'Cole um DOI (ex: URL ou 10.1109/ESEM.2019.8870160) ou digite o título exato do artigo',
    'submit' => 'Buscar',
    'tip' => 'Dica: cole um DOI completo (pode ser a URL do doi.org) ou apenas o título exato do artigo.',
    'references_title' => '🔎 Referências Encontradas (Backward)',
    'citations_title' => '📌 Citações Recebidas (Forward)',
    'no_references' => 'Nenhuma referência encontrada.',
    'no_citations' => 'Nenhuma citação encontrada.',
    'open_semantic' => 'Abrir no Semantic Scholar',
    'doi_not_found' => 'DOI não encontrado no Semantic Scholar.',
    'title_not_found' => 'Nenhum artigo encontrado para esse título.',
    'unexpected_error' => 'Erro inesperado ao buscar dados.',
    'validation.required' => 'Por favor, informe um DOI ou título exato do artigo.',
    'too_many_requests' => 'Busque com DOI ou verifique se digitou o título exato do artigo. Em alguns caso aguarde alguns minutos antes de tentar novamente, pois pode ter sido excedido o limite da API.',
];

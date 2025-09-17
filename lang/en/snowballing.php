<?php

return [
    'title' => 'Reference and Citation Search (Snowballing)',
    'modal' => [
        'title' => 'Help on Reference Search (Snowballing)',
        'content' => "
            <p>This module allows you to retrieve related articles (references and citations) starting from a seed article using the <strong>Semantic Scholar API</strong>.</p>

            <p><strong>It is highly recommended to use DOIs</strong> for searches, as the title-based search endpoints currently have technical and rate-limit constraints.</p>

            <p>These limitations are expected to be mitigated once the official API key for the <em>Thoth</em> tool is approved and applied.</p>

            <p>The results include basic metadata (title, authors, year, DOI, URL) along with lists of referenced (backward) and citing (forward) articles.</p>
        ",
    ],
    'input_label' => 'DOI or Title',
    'input_placeholder' => 'Paste a DOI (e.g., URL or 10.1109/ESEM.2019.8870160) or type the title',
    'submit' => 'Search',
    'tip' => 'Tip: paste a full DOI (can be a doi.org URL) or just the article title.',
    'references_title' => '🔎 References Found (Backward)',
    'citations_title' => '📌 Citations Received (Forward)',
    'no_references' => 'No references found.',
    'no_citations' => 'No citations found.',
    'open_semantic' => 'Open in Semantic Scholar',
    'doi_not_found' => 'DOI not found on Semantic Scholar.',
    'title_not_found' => 'No article found for this title.',
    'unexpected_error' => 'Unexpected error while fetching data.',
    'validation.required' => 'Please enter a DOI or title.',
];

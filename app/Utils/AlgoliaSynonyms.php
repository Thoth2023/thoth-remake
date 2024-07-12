<?php

namespace App\Utils;

use Algolia\AlgoliaSearch\SearchClient;

class AlgoliaSynonyms
{
    private $client;

    public function __construct()
    {
        $this->client = SearchClient::create(
            config('scout.algolia.id'), // Obtém o ID do App do arquivo de configuração
            config('scout.algolia.secret') // Obtém a chave API do arquivo de configuração
        );
    }

    public function createSynonym($objectID, $synonyms, $indexName = "synonyms")
    {
        $index = $this->client->initIndex($indexName);

        $synonymArray = [
            'objectID' => $objectID,
            'type' => 'synonym',
            'synonyms' => $synonyms
        ];

        $response = $index->saveSynonym($synonymArray);

        return $response;
    }

    public function searchSynonyms($wordOrTerm, $indexName = "synonyms")
    {
        $index = $this->client->initIndex($indexName);
        $results = $index->searchSynonyms($wordOrTerm, [
            'hitsPerPage' => 10,
        ]);

        $allSynonyms = [];

        foreach ($results['hits'] as $hit) {
            $filterSynonyms = array_filter($hit['synonyms'], function ($synonym) use ($wordOrTerm) {
                return strcasecmp($synonym, $wordOrTerm) !== 0;
            });

            $allSynonyms = array_merge($allSynonyms, $filterSynonyms);
        }

        $slicedSynonyms = array_slice($allSynonyms, 0, 10);

        return $slicedSynonyms;
    }
}

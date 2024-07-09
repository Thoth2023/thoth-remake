<?php
namespace App\Utils;

use Algolia\AlgoliaSearch\SearchClient;

class AlgoliaSynonyms
{
  private $client;

  public function __construct()
  {
    $this->client = SearchClient::create("UJMK9VGLGE", "2182b320da0625c7c4eff720d54f309f");
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

  public function searchSynonyms($query, $indexName = "synonyms")
  {
    $index = $this->client->initIndex($indexName);
    $results = $index->searchSynonyms($query, [
      'hitsPerPage' => 10,
    ]);

    $allSynonyms = [];
    foreach ($results['hits'] as $hit) {
      $allSynonyms = array_merge($allSynonyms, $hit['synonyms']);
    }

    $slicedSynonyms = array_slice($allSynonyms, 0, 10);

    return $slicedSynonyms;
  }
}
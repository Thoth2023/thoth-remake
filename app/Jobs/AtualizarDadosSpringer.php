<?php

namespace App\Jobs;

use App\Models\Project\Conducting\Papers;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AtualizarDadosSpringer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $paperId;
    protected $doi;

    public function __construct($paperId, $doi)
    {
        $this->paperId = $paperId;
        $this->doi = $doi;

        Log::info("Job criado para atualização via Springer para o paper ID {$this->paperId} com DOI: {$this->doi}");
    }

    public function handle()
    {
        Log::info("Iniciando o handle do job para o paper ID {$this->paperId}");

        $client = new Client([
            'base_uri' => 'https://api.springernature.com/',
            'timeout' => 30,
        ]);

        try {
            $apiKey = config('services.springer.api_key');
            $endpoint = 'metadata/pam?q=doi:' . $this->doi . '&api_key=' . $apiKey;
            Log::info("Fazendo a requisição para a API Springer no endpoint: $endpoint");

            $response = $client->get($endpoint);

            if ($response->getStatusCode() === 200) {
                $xmlData = $response->getBody()->getContents();

                // Logar o XML completo para inspeção
                Log::info("Resposta XML recebida da API Springer:", ['xml' => $xmlData]);

                $xml = new \SimpleXMLElement($xmlData);

                // Registrar namespaces e verificar se estão corretos
                $namespaces = $xml->getNamespaces(true);
                Log::info("Namespaces disponíveis:", $namespaces);

                $xml->registerXPathNamespace('xhtml', $namespaces['xhtml']);
                $xml->registerXPathNamespace('pam', $namespaces['pam']);
                $xml->registerXPathNamespace('prism', $namespaces['prism']);

                // Extrair Abstract
                $abstractElement = $xml->xpath('//xhtml:body/p');
                $abstract = $abstractElement ? (string) $abstractElement[0] : null;

                // Extrair Keywords
                $keywords = [];
                $facetKeywords = $xml->xpath('//facet[@name="keyword"]/facet-value');
                foreach ($facetKeywords as $keyword) {
                    $keywords[] = (string) $keyword;
                }

                Log::info("Dados extraídos:", [
                    'abstract' => $abstract,
                    'keywords' => $keywords
                ]);

                // Atualizar no banco de dados
                $paper = Papers::find($this->paperId);
                if ($paper) {
                    Log::info("Paper encontrado no banco de dados. Iniciando atualização.");

                    $paper->abstract = $abstract;
                    $paper->keywords = implode(', ', $keywords);
                    $paper->save();

                    Log::info("Atualização do paper concluída para o paper ID {$this->paperId}");
                } else {
                    Log::warning("Paper com ID {$this->paperId} não encontrado no banco de dados durante o processamento da API.");
                }
            } else {
                Log::error("Erro ao conectar com a API Springer. Status da resposta: " . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            Log::error("Erro ao buscar dados da Springer para o paper ID {$this->paperId}: " . $e->getMessage());
        }
    }


}

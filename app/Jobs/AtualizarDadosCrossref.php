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

class AtualizarDadosCrossref implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue = 'updates';

    protected $paperId;
    protected $doi;
    protected $title;

    public function __construct($paperId, $doi = null, $title = null)
    {
        $this->paperId = $paperId;
        $this->doi = $doi;
        $this->title = $title;

        Log::info("Job criado para o paper ID {$this->paperId} com DOI: {$this->doi} e título: {$this->title}");
    }

    public function handle()
    {
        Log::info("Iniciando o handle do job para o paper ID {$this->paperId}");

        // Teste para verificar se o modelo Papers está acessível no contexto do Job
        $paperCheck = Papers::find($this->paperId);
        if (!$paperCheck) {
            Log::error("Verificação: Papel com ID {$this->paperId} não encontrado antes mesmo da chamada API. Verifique a conexão de banco de dados.");
        } else {
            Log::info("Papel encontrado antes da chamada API: " . json_encode($paperCheck));
        }

        $client = new Client([
            'base_uri' => 'https://api.crossref.org/',
            'timeout' => 30,
        ]);

        try {
            $endpoint = !empty($this->doi)
                ? 'works/' . $this->doi
                : 'works?query.bibliographic=' . urlencode($this->title) . '&select=abstract,subject,DOI';

            Log::info("Fazendo a requisição para a API CrossRef no endpoint: $endpoint");

            $response = $client->get($endpoint);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);

                if (isset($data['message'])) {
                    $paperData = $data['message'];
                    Log::info("Dados do paper extraídos", ['abstract' => $paperData['abstract'] ?? 'N/A', 'keywords' => $paperData['subject'] ?? 'N/A']);

                    $paper = Papers::find($this->paperId);
                    if ($paper) {
                        Log::info("Paper encontrado no banco de dados. Iniciando atualização.");

                        $paper->abstract = $paperData['abstract'] ?? $paper->abstract;
                        $paper->keywords = isset($paperData['subject']) ? implode(', ', $paperData['subject']) : $paper->keywords;
                        if (empty($paper->doi) && isset($paperData['DOI'])) {
                            $paper->doi = $paperData['DOI'];
                        }
                        $paper->save();
                        Log::info("Atualização do paper concluída para o paper ID {$this->paperId}");
                    } else {
                        Log::warning("Paper com ID {$this->paperId} não encontrado no banco de dados durante o processamento da API.");
                    }
                } else {
                    Log::warning("A resposta da API não contém o campo 'message' esperado para o paper ID {$this->paperId}");
                }
            } else {
                Log::error("Erro ao conectar com a API CrossRef. Status da resposta: " . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            Log::error("Erro ao buscar dados do CrossRef para o paper ID {$this->paperId}: " . $e->getMessage());
        }
    }




}

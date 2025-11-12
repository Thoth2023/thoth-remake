<?php

namespace App\Jobs;

use App\Models\Project\Conducting\Papers;
use App\Services\SnowballingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AtualizarDadosSemantic implements ShouldQueue
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
        Log::info("Job criado para atualização via Semantic Scholar (paper ID: {$this->paperId})");
    }

    public function handle()
    {
        try {
            Log::info("Iniciando atualização via Semantic Scholar para o paper ID {$this->paperId}");

            $service = new SnowballingService();
            $query = !empty($this->doi) ? $this->doi : $this->title;

            $result = $service->fetch($query);

            if (!$result || empty($result['article'])) {
                Log::warning("Nenhum dado retornado do Semantic Scholar para o paper ID {$this->paperId}");
                return;
            }

            $article = $result['article'];
            $paper = Papers::find($this->paperId);

            if (!$paper) {
                Log::warning("Paper com ID {$this->paperId} não encontrado no banco de dados.");
                return;
            }

            // Priorizar DOI
            if (!empty($this->doi)) {
                $paper->title = $article['title'] ?? $paper->title;
            } elseif (!empty($this->title)) {
                $paper->doi = $article['doi'] ?? $paper->doi;
            }

            $paper->abstract = $article['abstract'] ?? $paper->abstract;
            $paper->keywords = $this->extractKeywords($article);
            $paper->author = $article['authors'] ?? $paper->author;

            if (!empty($article['url'])) {
                $paper->url = $article['url'];
            } elseif (!empty($paper->doi)) {
                $paper->url = str_contains($paper->doi, 'http')
                    ? $paper->doi
                    : 'https://doi.org/' . ltrim($paper->doi);
            }

            $paper->save();

            Log::info("Atualização via Semantic Scholar concluída para o paper ID {$this->paperId}");
        } catch (\Throwable $e) {
            Log::error("Erro ao processar atualização via Semantic Scholar: {$e->getMessage()}", [
                'paperId' => $this->paperId,
                'doi' => $this->doi,
                'title' => $this->title,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // rethrow para o sistema de filas registrar o erro
        }
    }

    private function extractKeywords(array $article): string
    {
        if (!empty($article['keywords'])) {
            if (is_array($article['keywords'])) {
                return implode(', ', $article['keywords']);
            }
            return $article['keywords'];
        }

        // Fallback: gerar palavras-chave a partir do abstract
        if (!empty($article['abstract'])) {
            $abstract = strtolower($article['abstract']);
            $words = array_filter(explode(' ', $abstract), fn($w) => strlen($w) > 6);
            $unique = array_slice(array_unique($words), 0, 8);
            return implode(', ', $unique);
        }

        return '';
    }
}

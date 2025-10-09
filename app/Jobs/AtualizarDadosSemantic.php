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

        // Atualizar campos conforme tipo de consulta (via DOI ou via título)
        if (empty($this->doi) && !empty($this->title)) {
            // Atualização via título → preencher DOI
            $paper->doi = $article['doi'] ?? $paper->doi;
        } elseif (!empty($this->doi) && empty($this->title)) {
            // Atualização via DOI → preencher título
            $paper->title = $article['title'] ?? $paper->title;
        }

        // Atualizar campos comuns
        $paper->abstract = $article['abstract'] ?? $paper->abstract;
        $paper->keywords = $this->extractKeywords($article);
        $paper->author = $article['authors'] ?? $paper->author;

        $paper->save();

        Log::info("Atualização via Semantic Scholar concluída para o paper ID {$this->paperId}");
    }

    private function extractKeywords(array $article): string
    {
        if (!empty($article['keywords'])) {
            if (is_array($article['keywords'])) {
                return implode(', ', $article['keywords']);
            }
            return $article['keywords'];
        }

        // Fallback: tentar inferir palavras-chave a partir do abstract
        if (!empty($article['abstract'])) {
            $abstract = strtolower($article['abstract']);
            $words = array_filter(explode(' ', $abstract), fn($w) => strlen($w) > 6);
            $unique = array_slice(array_unique($words), 0, 8);
            return implode(', ', $unique);
        }

        return '';
    }
}

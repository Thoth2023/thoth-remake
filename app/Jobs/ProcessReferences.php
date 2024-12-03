<?php

namespace App\Jobs;

use App\Models\Project\Conducting\PaperSnowballing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessReferences implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $references;
    protected $paper;
    protected $type;

    /**
     * Create a new job instance.
     */
    public function __construct(array $references, array $paper, string $type)
    {
        $this->references = $references;
        $this->paper = $paper;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info("Job ProcessReferences iniciado", [
            'type' => $this->type,
            'paper_id' => $this->paper['id_paper'] ?? null,
            'reference_id' => $this->paper['id'] ?? null,
        ]);

        if (empty($this->references)) {
            Log::warning("Nenhuma referência fornecida para processamento.", [
                'paper_id' => $this->paper['id_paper'] ?? null,
                'reference_id' => $this->paper['id'] ?? null,
            ]);
            return;
        }

        foreach ($this->references as $index => $ref) {
            $doi = $ref['DOI'] ?? null;
            $title = $ref['article-title'] ?? null;

           /* Log::info("Processando referência #{$index}", [
                'DOI' => $doi,
                'Título' => $title ?? 'Título desconhecido',
                'raw_reference' => $ref,
            ]);*/

            // Ignorar referências sem DOI e título
            if (is_null($doi) && (is_null($title) || trim($title) === '')) {
                Log::warning("Referência ignorada: Sem DOI e Título", ['reference' => $ref]);
                continue;
            }

            // Verifica duplicação por DOI (se presente) ou título
            $existing = PaperSnowballing::query()
                ->when($doi, function ($query) use ($doi) {
                    $query->where('doi', $doi);
                })
                ->when(!$doi && $title, function ($query) use ($title) {
                    $query->where('title', $title);
                })
                ->where(function ($query) {
                    $query->where('paper_reference_id', $this->paper['id_paper'] ?? null)
                        ->orWhere('parent_snowballing_id', $this->paper['id'] ?? null);
                })
                ->exists();

            if ($existing) {
                Log::info("Referência duplicada encontrada e ignorada", [
                    'DOI' => $doi,
                    'Título' => $title,
                ]);
                continue;
            }

            // Valida parent_snowballing_id
            $parentSnowballingId = null;
            if (!empty($this->paper['id'])) {
                $exists = PaperSnowballing::where('id', $this->paper['id'])->exists();
                if ($exists) {
                    $parentSnowballingId = $this->paper['id'];
                } else {
                    Log::warning("Parent Snowballing ID inválido, ignorando valor.", [
                        'invalid_id' => $this->paper['id'],
                    ]);
                }
            }

            // Prepara autores
            $authors = null;
            if (isset($ref['author']) && is_array($ref['author'])) {
                $authors = implode('; ', array_map(fn($author) =>
                    trim(($author['given'] ?? '') . ' ' . ($author['family'] ?? '')), $ref['author'])
                );
            } elseif (isset($ref['author']) && is_string($ref['author'])) {
                $authors = $ref['author'];
            }

            if (!$authors) {
                Log::warning("Autores ausentes ou inválidos para referência.", ['DOI' => $doi, 'Título' => $title]);
            }

            // Insere no banco de dados
            $newReference = PaperSnowballing::create([
                'paper_reference_id' => $this->paper['id_paper'] ?? null,
                'parent_snowballing_id' => $parentSnowballingId,
                'doi' => $doi,
                'title' => $title ?? 'unknown',
                'authors' => $authors,
                'year' => $ref['year'] ?? null,
                'abstract' => $ref['abstract'] ?? null,
                'keywords' => null,
                'type' => $ref['type'] ?? 'unknown',
                'bib_key' => $ref['key'] ?? null,
                'url' => $ref['URL'] ?? null,
                'type_snowballing' => $this->type,
                'is_duplicate' => false,
                'is_relevant' => null,
            ]);

            Log::info("Referência inserida com sucesso", [
                'DOI' => $doi,
                'Título' => $title ?? 'Título desconhecido',
            ]);

            // Atualiza metadados, se DOI estiver presente
            if ($doi) {
                $this->updateMetadata($newReference, $doi);
            }
        }

        Log::info("Job ProcessReferences concluído", [
            'total_references' => count($this->references),
            'type' => $this->type,
        ]);
    }

    /**
     * Atualiza título e autores de uma referência diretamente via API CrossRef.
     */
    private function updateMetadata(PaperSnowballing $reference, string $doi)
    {
        try {
            $response = Http::get('https://api.crossref.org/works/' . $doi);

            if ($response->successful()) {
                $data = $response->json()['message'] ?? [];

                $reference->update([
                    'title' => $data['title'][0] ?? $reference->title,
                    'authors' => isset($data['author'])
                        ? implode('; ', array_map(fn($author) => $author['given'] . ' ' . $author['family'], $data['author']))
                        : $reference->authors,
                    'year' => $data['issued']['date-parts'][0][0] ?? $reference->year, // Atualiza o ano
                    'url' => $data['URL'] ?? $reference->url, // Atualiza a URL
                    'type' => $data['type'] ?? $reference->type, // Atualiza o tipo
                ]);

                Log::info("Metadados atualizados com sucesso", [
                    'DOI' => $doi,
                    'updated_title' => $reference->title,
                    'updated_authors' => $reference->authors,
                    'updated_year' => $reference->year,
                    'updated_url' => $reference->url,
                    'updated_type' => $reference->type,
                ]);
            } else {
                Log::warning("Não foi possível atualizar os metadados para DOI: {$doi}", [
                    'status_code' => $response->status(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar metadados", [
                'DOI' => $doi,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

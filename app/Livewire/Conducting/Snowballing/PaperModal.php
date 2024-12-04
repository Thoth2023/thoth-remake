<?php

namespace App\Livewire\Conducting\Snowballing;


use App\Jobs\ProcessReferences;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\PaperSnowballing;
use App\Models\StatusSelection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;

class PaperModal extends Component
{

    public $currentProject;
    public $projectId;
    public $paper = null;

    public $selected_status = "None";

    public $references = [];
    public $searchType = null; // backward ou forward
    public $doi; // DOI do paper base para busca


    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);

    }

    #[On('showPaperSnowballing')]
    public function showPaperSnowballing($paper)
    {

        $this->paper = $paper;

        // Obtém o nome do banco de dados associado ao paper
        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        $this->doi = $paper['doi'] ?? null;

        // Atualizar o componente ReferencesTable
        $this->dispatch('update-references', [
            'paper_reference_id' => $this->paper['id_paper'] ?? null,
        ]);
        Log::info('Dispatched update-references', ['paper_reference_id' => $this->paper['id_paper'] ?? null]);

        // Dispara o evento para mostrar o modal
        $this->dispatch('show-paper-snowballing');
    }


    public function isAlreadyProcessed($type)
    {
        Log::info("Verificando se referências {$type} já foram processadas", [
            'paper_id' => $this->paper['id_paper'] ?? null,
            'reference_id' => $this->paper['id'] ?? null,
        ]);

        $query = PaperSnowballing::where('type_snowballing', $type);

        if (!empty($this->paper['id_paper'])) {
            $query->where('paper_reference_id', $this->paper['id_paper']);
        }

        if (!empty($this->paper['id'])) {
            $query->orWhere('parent_snowballing_id', $this->paper['id']);
        }

        return $query->exists();
    }


    public function handleReferenceType($type)
    {
        Log::info("Iniciando processamento de referências {$type}", [
            'paper_id' => $this->paper['id_paper'] ?? null,
            'reference_id' => $this->paper['id'] ?? null,
        ]);

        if ($this->isAlreadyProcessed($type)) {
            $message = "Referências {$type} já foram processadas para este paper!";
            Log::warning($message, [
                'paper_id' => $this->paper['id_paper'] ?? null,
                'reference_id' => $this->paper['id'] ?? null,
            ]);

            /*session()->flash('successMessage', [
                'message' => $message,
                'type' => 'warning',
            ]);*/

            session()->forget('successMessage');
            session()->flash('successMessage', $message);
            $this->dispatch('show-success-snowballing');
            return;
        }

        // Prossiga com a busca
        $this->fetchReferences($type);
    }

    public function fetchReferences($type)
    {
        Log::info("Buscando referências {$type}", ['doi' => $this->doi]);

        if (!$this->doi) {
            $message = "DOI não informado!";
            Log::error($message);

            session()->forget('successMessage');
            session()->flash('successMessage', $message);
            $this->dispatch('show-success-snowballing');
            return;
        }

        try {
            $response = Http::get('https://api.crossref.org/works/' . $this->doi);

            if ($response->successful()) {
                $data = $response->json();
                $references = $data['message']['reference'] ?? [];

                /*Log::info("Referências encontradas", [
                    'total' => count($references),
                    'references' => $references,
                ]);*/

                if (empty($references)) {
                    $message = "Nenhuma referência encontrada para o DOI.";
                    Log::warning($message, ['doi' => $this->doi]);

                    session()->forget('successMessage');
                    session()->flash('successMessage', $message);
                    $this->dispatch('show-success-snowballing');
                    return;
                }

                // Processa o job com as referências
                ProcessReferences::dispatch(
                    $references,
                    [
                        'id_paper' => $this->paper['id_paper'] ?? null,
                        'id' => $this->paper['id'] ?? null,
                    ],
                    $type
                );

                // Atualizar o componente ReferencesTable
                $this->dispatch('update-references');

                $message = ucfirst($type) . " processado com sucesso!";
                session()->forget('successMessage');
                session()->flash('successMessage', $message);
                $this->dispatch('show-success-snowballing');
            } else {
                $message = "Erro ao buscar referências na API CrossRef.";
                Log::error($message, ['status' => $response->status()]);

                session()->forget('successMessage');
                session()->flash('successMessage', $message);
                $this->dispatch('show-success-snowballing');
            }
        } catch (\Exception $e) {
            $message = "Erro ao processar referências: " . $e->getMessage();
            Log::error($message);

            session()->forget('successMessage');
            session()->flash('successMessage', $message);
            $this->dispatch('show-success-snowballing');
        }
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.paper-modal');
    }
}

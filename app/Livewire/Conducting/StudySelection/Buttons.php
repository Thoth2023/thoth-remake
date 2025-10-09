<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\ProjectDatabases;
use App\Utils\ActivityLogHelper as Log;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use TCPDF;
use Illuminate\Support\Facades\View;
use App\Utils\ToastHelper;
use Livewire\Attributes\On;


class Buttons extends Component
{

    private $translationPath = 'project/conducting.data-extraction.buttons';
    private $toastMessages = 'project/conducting.data-extraction.buttons';

    public $projectId;
    public $duplicates = []; // Armazena os papers duplicados organizados por título
    public $uniquePapers = [];
    public $exactDuplicateCount = 0;

    public $totalDuplicates = 0;
    public $hasPapers = false;

    protected function messages()
    {
        return [
            'no-papers' => __($this->translationPath . '.no-papers'),
        ];
    }

    private function translate(string $message, string $key = 'duplicates')
    {
        return __('project/conducting.study-selection.' . $key . '.' . $message);
    }

    public function removeDuplicates()
    {
        $member = Member::where('id_user', auth()->user()->id)->first();

        // Reinicializar as variáveis para evitar duplicações
        $this->uniquePapers = [];
        $this->duplicates = [];

        $papers = $this->getPapers($this->projectId);
        $uniqueTitles = [];

        foreach ($papers as $paper) {
            if (!in_array($paper->title, $uniqueTitles)) {
                // Se o título ainda não estiver na lista de títulos únicos
                $uniqueTitles[] = $paper->title;
            } else {
                // Se estiver na lista é um duplicado
                $this->duplicates[$paper->title][] = $paper;
            }
        }

        // lista de papers únicos, apenas os papers que têm duplicatas
        foreach ($uniqueTitles as $title) {
            if (isset($this->duplicates[$title])) {
                // Pegamos o primeiro paper com esse título como o 'único' (original)
                $originalPaper = Papers::where('title', $title)->first();
                $this->uniquePapers[] = $originalPaper;
            }
        }

        // Lógica de contagem de duplicados (considerando o membro atual)
        $duplicatesAllFields = Papers::select('papers.title', 'papers.year', 'papers.author')
            ->join('papers_selection', 'papers.id_paper', '=', 'papers_selection.id_paper') // Join com papers_selection
            ->where('papers_selection.id_member', $member->id_members)  // Filtra pelo membro atual na tabela papers_selection
            ->selectRaw('COUNT(*) as count')
            ->groupBy('papers.title', 'papers.year', 'papers.author')
            ->having('count', '>', 1)
            ->get();

        $this->exactDuplicateCount = 0; // Inicializa a contagem

        foreach ($duplicatesAllFields as $duplicate) {
            // Conta os duplicados com base no membro atual
            $duplicateCount = Papers::where('title', $duplicate->title)
                ->where('year', $duplicate->year)
                ->where('author', $duplicate->author)
                ->join('papers_selection', 'papers.id_paper', '=', 'papers_selection.id_paper') // Join com papers_selection
                ->where('papers_selection.id_member', $member->id_members)  // Filtra pelo membro atual
                ->count();

            if ($duplicateCount > 1) {
                // Incrementa o contador de duplicados exatos (descontando o original)
                $this->exactDuplicateCount += $duplicateCount - 1;
            }
        }
        // Verificar se há duplicados e exibir o modal
        if (count($this->duplicates) > 0) {
            $this->dispatch('show-duplicates-modal');
        } else {
            $this->toast(
                message: $this->translate('no-duplicates'),
                type: 'info',
            );
        }
    }

    public function confirmDuplicate($paperId)
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();
        // Busca o paper pelo ID
        $paper = Papers::where('id_paper', $paperId)->first();

        if ($paper) {
            // Atualiza o status do paper diretamente
            $paper->update(['status_selection' => 4]); // Status 'Duplicated'

            // Busca o registro na tabela PapersSelection correspondente ao paper
            $paperSelection = PapersSelection::where('id_paper', $paperId)
                ->where('id_member', $member->id_members) // Condição para o membro atual
                ->first();

            if ($paperSelection) {
                // Atualiza o status na tabela PapersSelection
                $paperSelection->update(['id_status' => 4]);

                // Exibe uma mensagem de sucesso
                /*$this->toast(
                    message: $this->translate('confirm-duplicate'),
                    type: 'success',
                );*/

                // Registra a atividade no log
                Log::logActivity(
                    action: 'Paper duplicated successfully marked',
                    description: $this->translate('confirm-duplicate'). ' - ' . $paperId,
                    projectId: $this->projectId,
                );
            } else {
                // Caso não exista um registro em PapersSelection, trate o erro ou adicione a lógica para criar.
                $this->toast("Erro: PaperSelection não encontrado para o Paper ID {$paperId}.", 'error');
            }
            // Remove o paper da lista de duplicatas sem recalcular tudo
            $this->removeFromDuplicates($paperId);

            // Recarrega os dados atualizados
            $this->refreshDuplicates();

            //  exibe modal de sucesso
            $this->dispatch('show-success-duplicates');
            $this->dispatch('refresh-duplicates-list');
        } else {
            // Se o paper não for encontrado, trate o erro
            $this->toast(
                message: $this->translate('erro-find-paper'),
                type: 'error',
            );
        }
    }
    public function rejectDuplicate($paperId)
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();
        // Busca o paper pelo ID
        $paper = Papers::where('id_paper', $paperId)->first();

        if ($paper) {
            // Atualiza o status do paper diretamente
            $paper->update(['status_selection' => 3]); // Status 'Unclassified'

            // Busca o registro na tabela PapersSelection correspondente ao paper
            $paperSelection = PapersSelection::where('id_paper', $paperId)
                ->where('id_member', $member->id_members) // Condição para o membro atual
                ->first();

            if ($paperSelection) {
                // Atualiza o status na tabela PapersSelection
                $paperSelection->update(['id_status' => 3]);

                // Exibe uma mensagem de sucesso
                /*$this->toast(
                    message: $this->translate('marked-unclassified'),
                    type: 'info',
                );*/

                // Registra a atividade no log
                Log::logActivity(
                    action: 'Paper marked as unclassified',
                    description: $this->translate('marked-unclassified'). ' - ' . $paperId,
                    projectId: $this->projectId,
                );
            } else {
                // Caso não exista um registro em PapersSelection, trate o erro ou adicione a lógica para criar.
                $this->toast("Erro: PaperSelection não encontrado para o Paper ID {$paperId}.", 'error');
            }
            // Remover o paper da lista de duplicatas sem recalcular tudo
            $this->removeFromDuplicates($paperId);

            // Recarrega os dados atualizados
            $this->refreshDuplicates();

            //  exibe modal de sucesso
            $this->dispatch('show-success-duplicates');
            $this->dispatch('refresh-duplicates-list');
        } else {
            // Se o paper não for encontrado, trate o erro
            $this->toast(
                message: $this->translate('erro-find-paper'),
                type: 'error',
            );
           }
    }

    private function refreshDuplicates()
    {
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $this->duplicates = [];
        $this->uniquePapers = [];

        // Recarrega os papers normalizados
        $papers = $this->getPapers($this->projectId)->map(function ($paper) {
            $paper->database = is_object($paper->database) ? ($paper->database->name ?? 'N/A') : $paper->database;
            return $paper;
        });

        $uniqueTitles = [];

        foreach ($papers as $paper) {
            if (!in_array($paper->title, $uniqueTitles)) {
                $uniqueTitles[] = $paper->title;
            } else {
                $this->duplicates[$paper->title][] = $paper;
            }
        }

        foreach ($uniqueTitles as $title) {
            if (isset($this->duplicates[$title])) {
                $originalPaper = Papers::where('title', $title)->first();
                $this->uniquePapers[] = $originalPaper;
            }
        }
    }



    private function removeFromDuplicates($paperId)
    {
        foreach ($this->duplicates as $title => $papers) {
            foreach ($papers as $index => $paper) {
                if ($paper->id_paper == $paperId) {
                    unset($this->duplicates[$title][$index]); // Remove o paper da lista
                }
            }
            // Se não restarem duplicatas para um determinado título, removemos o título também
            if (empty($this->duplicates[$title])) {
                unset($this->duplicates[$title]);
            }
        }
        // Se todas as duplicatas forem resolvidas, você pode opcionalmente fechar o modal
        if (empty($this->duplicates)) {
            $this->toast(
                message: $this->translate('analyse-all'),
                type: 'info',
            );
            $this->dispatch('show-success-duplicates');
        }
    }

    public function markAllDuplicates()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        // Busca duplicatas baseadas em título, ano e autor
        $duplicates = Papers::select('title', 'year', 'author')
            ->join('papers_selection', 'papers.id_paper', '=', 'papers_selection.id_paper') // Join com PapersSelection
            ->where('papers_selection.id_member', $member->id_members) // Filtrar pelo membro atual
            ->selectRaw('COUNT(*) as count')
            ->groupBy('title', 'year', 'author')
            ->having('count', '>', 1)
            ->get();

        // Contador total de duplicatas processadas
        $totalDuplicates = 0;

        foreach ($duplicates as $duplicate) {
            // Conta o número de papers com o mesmo título, ano e autor
            $papers = Papers::where('title', $duplicate->title)
                ->where('year', $duplicate->year)
                ->where('author', $duplicate->author)
                ->join('papers_selection', 'papers.id_paper', '=', 'papers_selection.id_paper')
                ->where('papers_selection.id_member', $member->id_members) // Filtrar pelo membro atual
                ->get();

            $duplicateCount = $papers->count();

            // Incrementa o contador de duplicados exatos
            if ($duplicateCount > 1) {
                $this->exactDuplicateCount += $duplicateCount - 1; // Contar somente os duplicados, excluindo o original
            }

            // Marcar todos como duplicados, exceto o primeiro (considerado o original)
            foreach ($papers->skip(1) as $paper) {
                $paper->update(['status_selection' => 4]); // Status 'Duplicated'

                // Atualiza a tabela de seleção de papers
                $paperSelection = PapersSelection::where('id_paper', $paper->id_paper)
                    ->where('id_member', $member->id_members) // Filtrar pelo membro atual
                    ->first();
                if ($paperSelection) {
                    $paperSelection->update(['id_status' => 4]);
                }

                // Incrementa o total de duplicados processados
                $totalDuplicates++;
            }
        }

        // Exibir uma notificação de sucesso
        if ($totalDuplicates > 0) {
            $this->toast(
                message: $this->translate('duplicates-all'),
                type: 'success',
            );
          } else {
            $this->toast(
                message: $this->translate('no-duplicates'),
                type: 'info',
            );
        }

        $this->dispatch('show-success-duplicates');
    }

    public function toast(string $message, string $type)
    {
        $this->dispatch('buttons', ToastHelper::dispatch($type, $message));
    }


    public function exportCsv()
    {
        $papers = $this->getPapersExport($this->projectId);

        // Verifica se existem papers para exportar
        if ($papers->isEmpty()) {
            $this->toast(
                message: $this->toastMessages . '.no-papers',
                type: 'error'
            );
            return;
        }

        $csvData = $this->formatCsv($papers);
        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'studies-selection.csv');
    }

    public function exportXml()
    {
        $papers = $this->getPapersExport($this->projectId);

        // Verifica se existem papers para exportar
        if ($papers->isEmpty()) {
            $this->toast(
                message: $this->toastMessages . '.no-papers',
                type: 'error'
            );
            return;
        }

        $xmlData = $this->formatXml($papers);
        return response()->streamDownload(function() use ($xmlData) {
            echo $xmlData;
        }, 'studies-selection.xml');
    }

    public function exportPdf()
    {
        $papers = $this->getPapersExport($this->projectId);

        // Verifica se existem papers para exportar
        if ($papers->isEmpty()) {
            $this->toast(
                message: $this->toastMessages . '.no-papers',
                type: 'error'
            );
            return;
        }

        $pdfData = $this->formatPdf($papers);
        return response()->streamDownload(function() use ($pdfData) {
            echo $pdfData;
        }, 'studies-selection.pdf');
    }

    private function getPapers()
    {
        // Obter os IDs dos bancos de dados do projeto
        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');

        $idsBib = [];
        if (count($idsDatabase) > 0) {
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        // Buscar os papers vinculados aos IDs das bibliotecas e ao membro atual
        $papers = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers.id_paper', '=', 'papers_selection.id_paper')
            ->where('papers_selection.id_member', $member->id_members)
            ->select('papers.*', 'papers_selection.id_member', 'papers_selection.id_status', 'data_base.name as database')
            ->get();

        // Normaliza o campo database para string simples
        return $papers->map(function ($paper) {
            $paper->database = is_object($paper->database) ? ($paper->database->name ?? 'N/A') : $paper->database;
            return $paper;
        });
    }

    private function getPapersExport()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        // Obter os IDs dos bancos de dados do projeto
        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');

        // Obter os IDs das bibliotecas associadas aos bancos de dados do projeto
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

        // Buscar os papers vinculados aos IDs das bibliotecas e ao membro atual
        return Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database') // Relacionar com o database
            ->join('papers_selection', 'papers.id_paper', '=', 'papers_selection.id_paper') // Relacionar com papers_selection
            ->join('members', 'members.id_members', '=', 'papers_selection.id_member')
            ->join('users', 'members.id_user', '=', 'users.id')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status') // Relacionar com status_selection
            ->leftJoin('evaluation_criteria', function($join) use ($member) {
                $join->on('papers.id_paper', '=', 'evaluation_criteria.id_paper')
                    ->where('evaluation_criteria.id_member', '=', $member->id_members); // Filtrar pelo membro atual
            })
            ->leftJoin('criteria', 'criteria.id_criteria', '=', 'evaluation_criteria.id_criteria') // Relacionar com criteria
            // Novo left join com a tabela paper_decision_conflicts para verificar conflitos na fase 'study-selection'
            ->leftJoin('paper_decision_conflicts', function($join) {
                $join->on('papers.id_paper', '=', 'paper_decision_conflicts.id_paper')
                    ->where('paper_decision_conflicts.phase', '=', 'study-selection'); // Filtrar pela fase 'study-selection'
            })
            ->where('papers_selection.id_member', $member->id_members) // Filtrar pelo membro atual
            ->select(
                'papers.id as id_paper',
                'papers.title',
                'data_base.name as database',
                'papers_selection.id_status',
                'status_selection.description as status',
                'papers_selection.note',
                'users.firstname',
                'users.lastname',
                DB::raw('GROUP_CONCAT(criteria.id ORDER BY criteria.id_criteria ASC SEPARATOR "-") as criterias'),
                'paper_decision_conflicts.new_status_paper' // Adicionar o campo new_status_paper ao select
            )
            ->groupBy(
                'papers.id_paper',
                'papers.title',
                'data_base.name',
                'papers_selection.id_status',
                'status_selection.description',
                'papers_selection.note',
                'paper_decision_conflicts.new_status_paper' // Incluir no groupBy para evitar erros de agregação
            )
            ->distinct()
            ->get();
    }

    private function formatCsv($papers)
    {
        $csvData = "Study Selection, Researcher: {$papers->first()->firstname} {$papers->first()->lastname}\n";
        $csvData .= "ID,Title,I/E Criteria,Database,Status,Peer Review\n";

        foreach ($papers as $paper) {
            $criterias = $paper->criterias ?? 'N/A'; // Critérios de inclusão/exclusão já concatenados
            $database = $paper->database ?? 'N/A'; // Database
            $status = $paper->status ?? 'N/A'; // Status do paper

            // Condição para verificar o status de avaliação por pares
            if ($paper->new_status_paper == 1) {
                $newStatus = 'Accepted';
            } elseif ($paper->new_status_paper == 2) {
                $newStatus = 'Rejected';
            } else {
                $newStatus = 'N/A'; // Caso não seja 1 ou 2, definir como N/A
            }
            // Montar a linha CSV
            $csvData .= "{$paper->id_paper},\"{$paper->title}\",{$criterias},{$database},{$status},{$newStatus}\n";
        }

        return $csvData;
    }

    private function formatXml($papers)
    {
        $xmlData = new \SimpleXMLElement('<papers/>');

        // Adiciona o cabeçalho com o nome do pesquisador (usando o primeiro paper da coleção)
        $researcherName = "Researcher: {$papers->first()->firstname} {$papers->first()->lastname}";
        $xmlData->addChild('study_selection', "Study Selection, {$researcherName}");

        foreach ($papers as $paper) {
            $paperElement = $xmlData->addChild('paper');
            $paperElement->addChild('id', $paper->id_paper); // Corrigido para 'id_paper'
            $paperElement->addChild('title', htmlspecialchars($paper->title)); // Evitar problemas com caracteres especiais
            $paperElement->addChild('criteria', $paper->criterias ?? 'N/A'); // Critérios de inclusão/exclusão
            $paperElement->addChild('database', htmlspecialchars($paper->database ?? 'N/A')); // Database
            $paperElement->addChild('status', $paper->status ?? 'N/A'); // Status do paper

            // Condição para verificar o status de avaliação por pares
            if ($paper->new_status_paper == 1) {
                $peerReviewStatus = 'Accepted';
            } elseif ($paper->new_status_paper == 2) {
                $peerReviewStatus = 'Rejected';
            } else {
                $peerReviewStatus = 'N/A'; // Caso não seja 1 ou 2
            }
            $paperElement->addChild('peer_review', $peerReviewStatus); // Avaliação por pares (Peer Review)
        }
        return $xmlData->asXML();
    }


    private function formatPdf($papers)
    {
        // Renderiza a view Blade com os dados
        $html = View::make('pdf.papers', compact('papers'))->render();

        // Inicia o PDF em modo paisagem (orientação 'L')
        $pdf = new TCPDF('L', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        // Escreve o conteúdo HTML no PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Retorna o PDF gerado
        return $pdf->Output('studies-selection.pdf', 'S');
    }

    public function mount() {
        $this->projectId = request()->segment(2);
        $this->checkPapersAvailability();
    }

    public function checkPapersAvailability()
    {
        try {
            $papers = $this->getPapersExport();
            $this->hasPapers = $papers->isNotEmpty();
        } catch (\Exception $e) {
            $this->hasPapers = false;
        }
    }

    public function render()
    {
        // Verificar novamente se existem papers disponíveis antes de renderizar
        $this->checkPapersAvailability();
        return view('livewire.conducting.study-selection.buttons');
    }

    #[On('papers-updated')]
    public function updatePapersAvailability($hasPapers)
    {
        $this->hasPapers = $hasPapers;
    }
}

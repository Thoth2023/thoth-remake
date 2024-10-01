<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\ProjectDatabases;
use App\Utils\ActivityLogHelper as Log;
use Livewire\Component;
use TCPDF;
use App\Utils\ToastHelper;


class Buttons extends Component
{
    public $projectId;
    public $duplicates = []; // Armazena os papers duplicados organizados por título
    public $uniquePapers = [];
    public $exactDuplicateCount = 0;

    public $totalDuplicates = 0;

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
        $member = Member::where('id_user', auth()->user()->id)->first();
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
                $this->toast(
                    message: $this->translate('confirm-duplicate'),
                    type: 'success',
                );
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

            // Atualizar a view para refletir as mudanças
            $this->dispatch('refresh');
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
        $member = Member::where('id_user', auth()->user()->id)->first();
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
                $this->toast(
                    message: $this->translate('marked-unclassified'),
                    type: 'info',
                );

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
            // Atualizar a view para refletir as mudanças
            $this->dispatch('refresh');
        } else {
            // Se o paper não for encontrado, trate o erro
            $this->toast(
                message: $this->translate('erro-find-paper'),
                type: 'error',
            );
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
        $member = Member::where('id_user', auth()->user()->id)->first();

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
        $papers = $this->getPapers($this->projectId);
        $csvData = $this->formatCsv($papers);
        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'studies.csv');
    }

    public function exportXml()
    {
        $papers = $this->getPapers($this->projectId);
        $xmlData = $this->formatXml($papers);
        return response()->streamDownload(function() use ($xmlData) {
            echo $xmlData;
        }, 'studies.xml');
    }

    public function exportPdf()
    {

        $papers = $this->getPapers($this->projectId);
        $pdfData = $this->formatPdf($papers);
        return response()->streamDownload(function() use ($pdfData) {
            echo $pdfData;
        }, 'studies.pdf');
    }

    private function getPapers()
    {
        // Obter os IDs dos bancos de dados do projeto
        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');

        $idsBib = [];
        if (count($idsDatabase) > 0) {
            // Obter os IDs das bibliotecas associadas aos bancos de dados do projeto
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        // Obter o membro atual da sessão
        $member = Member::where('id_user', auth()->user()->id)->first();

        // Buscar os papers vinculados aos IDs das bibliotecas e que estão associados ao membro atual
        return Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers.id_paper', '=', 'papers_selection.id_paper') // Associar com a tabela papers_selection
            ->where('papers_selection.id_member', $member->id_members) // Filtrar pelo membro atual
            ->select('papers.*', 'papers_selection.id_member', 'papers_selection.id_status', 'data_base.name as database') // Garantir que apenas os campos da tabela papers sejam retornados
            ->get();
    }

    private function formatCsv($papers)
    {
        $csvData = "ID,Title, Acceptance Criteria, Rejection Criteria, Database, Status\n";

        foreach ($papers as $paper) {
            $criteriaAcceptance = $paper->criteriaAcceptance ?? '';
            $criteriaRejection = $paper->criteriaRejection ?? '';
            $database = $paper->data_base->name ?? '';
            $status = $paper->status_criteria->description ?? '';

            $csvData .= "{$paper->id},{$paper->title},$criteriaAcceptance,$criteriaRejection,$database,$status\n";
        }

        return $csvData;
    }

    private function formatXml($papers)
    {
        $xmlData = new \SimpleXMLElement('<papers/>');

        foreach ($papers as $paper) {
            $paperElement = $xmlData->addChild('paper');
            $paperElement->addChild('id', $paper->id);
            $paperElement->addChild('title', $paper->title);
            $paperElement->addChild('criteria_acceptance', $paper->criteriaAcceptance ?? '');
            $paperElement->addChild('criteria_rejection', $paper->criteriaRejection ?? '');
            $paperElement->addChild('database', $paper->database->name ?? '');
            $paperElement->addChild('status', $paper->status ?? '');

        }

        return $xmlData->asXML();
    }

    private function formatPdf($papers)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        $html = '<h1>Study Selection</h1>';
        $html .= '<table border="1" cellpadding="2" cellspacing="2">';
        $html .= '<thead><tr><th>ID</th><th>Title</th><th>Acceptance Criteria</th><th>Rejection Criteria</th><th>Database</th><th>Status</th></tr></thead><tbody>';

        foreach ($papers as $paper) {
            $criteriaAcceptance = $paper->criteriaAcceptance ?? '';
            $criteriaRejection = $paper->criteriaRejection ?? '';
            $database = $paper->database->name ?? '';
            $status = $paper->status->description ?? '';

            $html .= "<tr><td>{$paper->id}</td><td>{$paper->title}</td><td>$criteriaAcceptance</td><td>$criteriaRejection</td><td>$database</td><td>$status</td></tr>";
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf->Output('studies.pdf', 'S');
    }


    public function mount() {
        $this->projectId = request()->segment(2);

    }

    public function render()
    {
        return view('livewire.conducting.study-selection.buttons');
    }
}

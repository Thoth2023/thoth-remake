<?php

namespace App\Livewire\Reporting;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use Livewire\Component;
use TCPDF;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\On;


class PeerReviewQualityButtons extends Component
{

    public $projectId;
    public $hasPapers = false;


    public function exportCsv()
    {
        $papers = $this->getPapersExport($this->projectId);
        $csvData = $this->formatCsv($papers);
        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'studies-qa.csv');
    }

    public function exportXml()
    {
        $papers = $this->getPapersExport($this->projectId);
        $xmlData = $this->formatXml($papers);
        return response()->streamDownload(function() use ($xmlData) {
            echo $xmlData;
        }, 'studies-qa.xml');
    }

    public function exportPdf()
    {

        $papers = $this->getPapersExport($this->projectId);
        $pdfData = $this->formatPdf($papers);
        return response()->streamDownload(function() use ($pdfData) {
            echo $pdfData;
        }, 'studies-qa.pdf');
    }

    private function getPapersExport()
    {
        // Obter o membro atual da sessão
        $member = Member::where('id_user', auth()->user()->id)->first();

        // Obter os IDs dos bancos de dados do projeto
        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');

        // Obter os IDs das bibliotecas associadas aos bancos de dados do projeto
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

        // Buscar os papers vinculados aos IDs das bibliotecas e ao membro atual
        return Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
            ->join('general_score', 'papers_qa.id_gen_score', '=', 'general_score.id_general_score')
            ->join('members', 'members.id_members', '=', 'papers_qa.id_member')
            ->join('users', 'members.id_user', '=', 'users.id')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers_qa.id_paper')
            ->select('papers.*',
                'papers.id as id_paper',
                'data_base.name as database_name',
                'general_score.description as general_score',
                'papers_qa.id_status as id_status_quality',
                'users.firstname',
                'users.lastname',
                'paper_decision_conflicts.new_status_paper',
                'status_qa.status as status_description')

            ->leftJoin('paper_decision_conflicts', function($join) {
                $join->on('papers.id_paper', '=', 'paper_decision_conflicts.id_paper')
                    ->where('paper_decision_conflicts.phase', '=', 'quality'); // Filtrar pela fase 'quality'
            })
            // Filtrar papers que tenham `id_status = 1` ou `id_status = 2` com base em condições
            ->where(function ($query) {
                $query->where('papers_selection.id_status', 1)
                    ->orWhere(function ($query) {
                        $query->where('papers_selection.id_status', 2)
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })

            // Filtrando pelo membro correto
            ->where('papers_selection.id_member', $member->id_members)
            ->where('papers_qa.id_member', $member->id_members)
            ->distinct()
            ->get();
    }

    private function formatCsv($papers)
    {
        $csvData = "QA, Researcher: {$papers->first()->firstname} {$papers->first()->lastname}\n";
        $csvData .= "ID,Title,General Score,Score,Status,Peer Review\n";

        foreach ($papers as $paper) {
            $generalScore = $paper->general_score ?? 'N/A'; // Critérios de inclusão/exclusão já concatenados
            $score = $paper->score ?? 'N/A';
            $database = $paper->database ?? 'N/A'; // Database
            $status = $paper->status_description ?? 'N/A'; // Status do paper

            // Condição para verificar o status de avaliação por pares
            if ($paper->new_status_paper == 1) {
                $newStatus = 'Accepted';
            } elseif ($paper->new_status_paper == 2) {
                $newStatus = 'Rejected';
            } else {
                $newStatus = 'N/A'; // Caso não seja 1 ou 2, definir como N/A
            }
            // Montar a linha CSV
            $csvData .= "{$paper->id_paper},\"{$paper->title}\",{$generalScore},{$score},{$status},{$newStatus}\n";
        }
        return $csvData;
    }

    private function formatXml($papers)
    {
        $xmlData = new \SimpleXMLElement('<papers/>');

        // Adiciona o cabeçalho com o nome do pesquisador (usando o primeiro paper da coleção)
        $researcherName = "Researcher: {$papers->first()->firstname} {$papers->first()->lastname}";
        $xmlData->addChild('study_qa', "Quality Assessment, {$researcherName}");

        foreach ($papers as $paper) {
            $paperElement = $xmlData->addChild('paper');
            $paperElement->addChild('id', $paper->id_paper); // Corrigido para 'id_paper'
            $paperElement->addChild('title', htmlspecialchars($paper->title)); // Evitar problemas com caracteres especiais
            $paperElement->addChild('general-score', $paper->general_score ?? 'N/A'); // Critérios de inclusão/exclusão
            $paperElement->addChild('score', htmlspecialchars($paper->score ?? 'N/A')); // Database
            $paperElement->addChild('status', $paper->status_description ?? 'N/A'); // Status do paper

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
        $html = View::make('pdf.papers-quality', compact('papers'))->render();

        // Inicia o PDF em modo paisagem (orientação 'L')
        $pdf = new TCPDF('L', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        // Escreve o conteúdo HTML no PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Retorna o PDF gerado
        return $pdf->Output('studies-qa.pdf', 'S');
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
        return view('livewire.reporting.peer-review-quality-buttons');
    }

    #[On('papers-updated')]
    public function updatePapersAvailability($hasPapers)
    {
        $this->hasPapers = $hasPapers;
    }
}

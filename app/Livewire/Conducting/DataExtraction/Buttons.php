<?php

namespace App\Livewire\Conducting\DataExtraction;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Utils\ActivityLogHelper as Log;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use TCPDF;
use App\Utils\ToastHelper;


class Buttons extends Component
{

    public $projectId;


    public function exportCsv()
    {
        $papers = $this->getPapersExport($this->projectId);
        $csvData = $this->formatCsv($papers);
        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'studies-extraction.csv');
    }

    public function exportXml()
    {
        $papers = $this->getPapersExport($this->projectId);
        $xmlData = $this->formatXml($papers);
        return response()->streamDownload(function() use ($xmlData) {
            echo $xmlData;
        }, 'studies-extraction.xml');
    }

    public function exportPdf()
    {

        $papers = $this->getPapersExport($this->projectId);
        $pdfData = $this->formatPdf($papers);
        return response()->streamDownload(function() use ($pdfData) {
            echo $pdfData;
        }, 'studies-extraction.pdf');
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
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('status_extraction', 'papers.status_extraction', '=', 'status_extraction.id_status')
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->join('members', 'members.id_members', '=', 'papers_qa.id_member')
            ->join('users', 'members.id_user', '=', 'users.id')
            ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')

            // Filtrar papers que tenham `id_status = 1` ou `id_status = 2` com base em condições
            ->where(function ($query) {
                $query->where('papers_qa.id_status', 1)
                    ->orWhere(function ($query) {
                        $query->where('papers_qa.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'quality')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })
            // Filtrando pelo membro correto
            ->where('papers.status_qa', 1)
            ->where('papers_qa.id_member', $member->id_members)
            ->distinct()
            ->select('papers.id as id_paper',
                'papers.title',
                'papers.year',
                'data_base.name as database_name',
                'users.firstname',
                'users.lastname',
                'status_extraction.description as status_description')
            ->get();
    }

    private function formatCsv($papers)
    {
        $csvData = "Extract, Researcher: {$papers->first()->firstname} {$papers->first()->lastname}\n";
        $csvData .= "ID,Title,Year,Database,Status,\n";

        foreach ($papers as $paper) {
            $generalScore = $paper->general_score ?? 'N/A'; // Critérios de inclusão/exclusão já concatenados
            $database = $paper->database_name ?? 'N/A'; // Database
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
            $csvData .= "{$paper->id_paper},\"{$paper->title}\",{$paper->year},{$database},{$status}\n";
        }
        return $csvData;
    }

    private function formatXml($papers)
    {
        $xmlData = new \SimpleXMLElement('<papers/>');

        // Adiciona o cabeçalho com o nome do pesquisador (usando o primeiro paper da coleção)
        $researcherName = "Researcher: {$papers->first()->firstname} {$papers->first()->lastname}";
        $xmlData->addChild('study_de', "Data Extraction, {$researcherName}");

        foreach ($papers as $paper) {
            $paperElement = $xmlData->addChild('paper');
            $paperElement->addChild('id', $paper->id_paper); // Corrigido para 'id_paper'
            $paperElement->addChild('title', htmlspecialchars($paper->title)); // Evitar problemas com caracteres especiais
            $paperElement->addChild('year', $paper->year ?? 'N/A');
            $paperElement->addChild('database', htmlspecialchars($paper->database_name ?? 'N/A')); // Database
            $paperElement->addChild('status', $paper->status_description ?? 'N/A'); // Status do paper

        }
        return $xmlData->asXML();
    }

    private function formatPdf($papers)
    {
        // Renderiza a view Blade com os dados
        $html = View::make('pdf.papers-extraction', compact('papers'))->render();

        // Inicia o PDF em modo paisagem (orientação 'L')
        $pdf = new TCPDF('L', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        // Escreve o conteúdo HTML no PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Retorna o PDF gerado
        return $pdf->Output('studies-extraction.pdf', 'S');
    }


    public function mount() {
        $this->projectId = request()->segment(2);
    }

    public function render()
    {
        return view('livewire.conducting.data-extraction.buttons');
    }
}

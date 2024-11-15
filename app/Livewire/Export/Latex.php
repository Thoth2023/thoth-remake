<?php

namespace App\Livewire\Export;

use App\Jobs\DeleteFileLatexJob;
use App\Models\BibUpload;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use App\Models\StatusQualityAssessment;
use App\Models\StatusSelection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Project;
use ZipArchive;

// Certifique-se de ajustar o namespace conforme seu modelo

class Latex extends Component
{
    public $projectId; // ID do projeto para exportação
    public $selectedOptions = []; // Armazena as opções selecionadas
    public $description = ''; // Conteúdo LaTeX gerado

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        //dd($projectId);
    }

    // Método para atualizar o conteúdo LaTeX com base nas seleções
    public function updatedSelectedOptions()
    {
        $this->generateLatex();
    }

    // Geração de conteúdo LaTeX
    public function generateLatex()
    {
        // Obtém o projeto para exportação
        $project = Project::with(['domains', 'languages', 'studyTypes', 'keywords', 'researchQuestions','userByProject'])->find($this->projectId);

        if (!$project) {
            $this->description = 'Project not found';
            session()->flash('successMessage', 'Could not generate LaTeX content: Project not found.');
            $this->dispatch('show-success-modal');
            return;
        }

        // Recupera o nome do autor
        $author = $project->userByProject ? $project->userByProject->firstname . ' ' . $project->userByProject->lastname : 'Autor Desconhecido';
        $author_email= $project->userByProject ? $project->userByProject->email  : 'Sem E-mail';

        // Início do documento LaTeX
        $latexContent = "";
        $latexContent .= "\\documentclass[11pt]{article}\n";
        $latexContent .= "\\usepackage[utf8]{inputenc}\n";
        $latexContent .= "\\usepackage{graphicx}\n";
        $latexContent .= "\\usepackage{booktabs}\n";
        $latexContent .= "\\usepackage{float}\n";
        $latexContent .= "\\usepackage[alf]{abntex2cite}\n";
        $latexContent .= "\\usepackage[brazilian,hyperpageref]{backref}\n";
        $latexContent .= "\\renewcommand{\\backrefpagesname}{Citado na(s) página(s):~}\n";
        $latexContent .= "\\renewcommand{\\backref}{}\n";
        $latexContent .= "\\renewcommand*{\\backrefalt}[4]{%\n";
        $latexContent .= "\\ifcase #1 %\n";
        $latexContent .= "Nenhuma citação no texto.%\n";
        $latexContent .= "\\or\n";
        $latexContent .= "Citado na página #2.%\n";
        $latexContent .= "\\else\n";
        $latexContent .= "Citado #1 vezes nas páginas #2.%\n";
        $latexContent .= "\\fi}\n";
        $latexContent .= "\\title{" . $project->title . "}\n";
        $latexContent .= "\\author{" . $author . " (".$author_email.")}\n\n";
        $latexContent .= "\\begin{document}\n";
        $latexContent .= "\\maketitle\n";
        $latexContent .= "\\begin{abstract}\n";
        $latexContent .= "" . $project->description . "\n";
        $latexContent .= "\\end{abstract}\n\n";

        // Adiciona seções com base nas seleções feitas no frontend
        if (in_array('planning', $this->selectedOptions)) {
            $latexContent .= $this->generatePlanningSection($project);
        }
        if (in_array('import_studies', $this->selectedOptions)) {
            $latexContent .= $this->generateImportStudiesSection($project);
        }
        if (in_array('study_selection', $this->selectedOptions)) {
            $latexContent .= $this->generateStudySelectionSection($project);
        }
        if (in_array('quality_assessment', $this->selectedOptions)) {
            $latexContent .= $this->generateQualityAssessmentSection($project);
        }
        if (in_array('snowballing', $this->selectedOptions)) {
            $latexContent .= $this->generateSnowballingSection($project);
        }

        // Finaliza o documento
        $latexContent .= "\\bibliography{Bib}\n";
        $latexContent .= "\\end{document}";

        $this->description = $latexContent;

        // Envia mensagem de sucesso para o frontend
        session()->flash('successMessage', 'LaTeX content generated successfully!');
        $this->dispatch('show-success-modal');
    }

    protected function generatePlanningSection($project)
    {
        $content = "\section{Planning}\n\n";

        // Descrição e Objetivos
        $content .= "\subsection{Description}\n" . $project->description . "\n\n";
        $content .= "\subsection{Objectives}\n" . $project->objectives . "\n\n";

        // Domínios
        $content .= "\subsection{Domains}\n\\begin{itemize}\n";
        foreach ($project->domains as $domain) {
            $content .= "\t\\item " . $domain->description . "\n";
        }
        $content .= "\\end{itemize}\n\n";

        // Idiomas
        $content .= "\subsection{Languages}\n\\begin{itemize}\n";
        foreach ($project->languages as $language) {
            $content .= "\t\\item " . $language->description . "\n";
        }
        $content .= "\\end{itemize}\n\n";

        // Tipos de Estudos
        $content .= "\subsection{Study Types}\n\\begin{itemize}\n";
        foreach ($project->studyTypes as $type) {
            $content .= "\t\\item " . $type->description . "\n";
        }
        $content .= "\\end{itemize}\n\n";

        // Palavras-chave
        $content .= "\subsection{Keywords}\n";
        foreach ($project->keywords as $keyword) {
            $content .= $keyword->description . ". ";
        }
        $content .= "\n\n";

        // Perguntas de Pesquisa
        $content .= "\subsection{Research Questions}\n\\begin{itemize}\n";
        foreach ($project->researchQuestions as $question) {
            $content .= "\t\\item \\textbf{" . $question->id . "} " . $question->description . "\n";
        }
        $content .= "\\end{itemize}\n\n";

        // Bases de Dados
        if ($project->databases->isNotEmpty()) {
            $content .= "\\subsection{Databases}\n";
            $content .= "\\begin{table}[!htb]\n";
            $content .= "\\caption[Databases used at work]{Databases used at work.}\n";
            $content .= "\\label{tab:databases}\n";
            $content .= "\\centering\n";
            $content .= "\\begin{tabular}{@{}ll@{}}\n";
            $content .= "\\toprule\n";
            $content .= "\\textbf{Database} & \\textbf{Link} \\\\ \\midrule\n";

            foreach ($project->databases as $database) {
                $content .= $database->name . " & " . $database->link . " \\\\\n";
            }

            $content .= "\\bottomrule\n";
            $content .= "\\end{tabular}\n";
            $content .= "\\end{table}\n\n";
        } else {
            $content .= "\\subsection{Databases}\n";
            $content .= "No databases registered for this project.\n\n";
        }

        return $content;
    }

    protected function generateImportStudiesSection($project)
    {
        // Recuperar bases de dados associadas ao projeto
        $databases = $project->databases;

        if ($databases->isEmpty()) {
            return "\\section{Import Studies}\n\nNo databases associated with this project.\n\n";
        }

        // Início da seção LaTeX
        $content = "\\section{Import Studies}\n\n";
        $content .= "\\subsection{Studies per Database}\n";
        $content .= "\\begin{table}[!htb]\n";
        $content .= "\\caption[Studies per Database]{Studies per Database.}\n";
        $content .= "\\label{tab:studiesDatabases}\n";
        $content .= "\\centering\n";
        $content .= "\\begin{tabular}{@{}ll@{}}\n";
        $content .= "\\toprule\n";
        $content .= "\\textbf{Database} & \\textbf{Number of Studies} \\\\ \\midrule\n";

        // Iterar pelas bases de dados para contar os estudos
        foreach ($databases as $database) {
            $count = BibUpload::countPapersByDatabase($project->id_project, $database->id_database);
            $content .= $database->name . " & " . $count . " \\\\\n";
        }

        // Fechamento da tabela
        $content .= "\\bottomrule\n";
        $content .= "\\end{tabular}\n";
        $content .= "\\end{table}\n\n";

        return $content;
    }


    protected function generateStudySelectionSection($project)
    {
        // Recuperar todos os status de seleção disponíveis
        $statuses = StatusSelection::all();

        if ($statuses->isEmpty()) {
            return "\\section{Selection Studies}\n\nNo status selection data available.\n\n";
        }

        // Inicializar tabela LaTeX
        $content = "\\section{Selection Studies}\n\n";
        $content .= "\\subsection{Studies per Status Selection}\n";
        $content .= "\\begin{table}[!htb]\n";
        $content .= "\\caption[Studies per Status Selection]{Studies per Status Selection.}\n";
        $content .= "\\label{tab:studiesSelection}\n";
        $content .= "\\centering\n";
        $content .= "\\begin{tabular}{@{}ll@{}}\n";
        $content .= "\\toprule\n";
        $content .= "\\textbf{Status} & \\textbf{Number of Studies} \\\\ \\midrule\n";

        $totalStudies = 0;

        // Iterar sobre cada status e contar os estudos
        foreach ($statuses as $status) {
            $count = Papers::query()
                ->whereHas('bibUpload.projectDatabase', function ($query) use ($project) {
                    $query->where('id_project', $project->id_project);
                })
                ->where('status_selection', $status->id_status)
                ->count();

            $content .= "{$status->description} & {$count} \\\\\n";
            $totalStudies += $count;
        }

        // Adicionar linha de total
        $content .= "Total & {$totalStudies} \\\\\n";

        // Fechar tabela
        $content .= "\\bottomrule\n";
        $content .= "\\end{tabular}\n";
        $content .= "\\end{table}\n\n";

        return $content;
    }


    protected function generateQualityAssessmentSection($project)
    {
        // Filtrar os papers com status_qa "Accepted" para o projeto específico
        $acceptedStatusId = StatusQualityAssessment::where('status', 'Accepted')->value('id_status');

        if (!$acceptedStatusId) {
            return "\\section{Quality Assessment}\n\nNo Accepted Quality Assessment data available.\n\n";
        }

        // Obter os papers com status de QA "Accepted" e pertencentes ao projeto atual
        $papersQA = PapersQA::with(['papers.bibUpload.projectDatabase', 'generalScore', 'status_qa'])
            ->where('id_status', $acceptedStatusId) // Filtrar diretamente pelo status "Accepted" em papers_qa
            ->whereHas('papers', function ($query) use ($acceptedStatusId, $project) {
                // Filtrar os papers com status_qa = "Accepted" e pertencentes ao projeto atual
                $query->where('status_qa', $acceptedStatusId)
                    ->whereHas('bibUpload.projectDatabase', function ($subQuery) use ($project) {
                        $subQuery->where('id_project', $project->id_project);
                    });
            })
            ->get();


        if ($papersQA->isEmpty()) {
            return "\\section{Quality Assessment}\n\nNo Accepted Quality Assessment data available.\n\n";
        }

        // Inicializar o conteúdo LaTeX
        $content = "\\section{Quality Assessment}\n\n";
        $content .= "\\subsection{Quality Assessment}\n";
        $content .= "\\begin{table}[!htb]\n";
        $content .= "\\caption[Quality Assessment]{Quality Assessment.}\n";
        $content .= "\\label{tab:studiesQuality}\n";
        $content .= "\\centering\n";
        $content .= "\\begin{tabular}{@{}lllllll@{}}\n";
        $content .= "\\toprule\n";
        $content .= "\\textbf{ID} & \\textbf{General Score} & \\textbf{Score} & \\textbf{Status} \\\\ \\midrule\n";

        // Preencher a tabela com os dados
        foreach ($papersQA as $paperQA) {
            $paperId = $paperQA->papers->id ?? 'N/A';
            $generalScore = $paperQA->generalScore->description ?? 'N/A';
            $score = $paperQA->score ?? 'N/A';
            $status = $paperQA->status_qa->status ?? 'N/A';

            $content .= "\\citeonline{{$paperId}} & {$generalScore} & {$score} & {$status} \\\\\n";
        }

        // Fechar tabela
        $content .= "\\bottomrule\n";
        $content .= "\\end{tabular}\n";
        $content .= "\\end{table}\n\n";

        return $content;
    }


    protected function generateSnowballingSection($project)
    {
        // Inicializar o conteúdo LaTeX
        $content = "\\section{Snowballing}\n\n";
        $content .= "Dados ainda não disponíveis para essa seção.\n\n";
        return $content;
    }


    // Formatação básica de cada seção LaTeX
    public function formatLatexSection($title, $content)
    {
        return "\\section*{{$title}}\n{$content}\n\n";
    }

    public function exportToOverleaf()
    {
        // Certifique-se de que o conteúdo do textarea foi capturado
        if (empty($this->description)) {
            session()->flash('error', 'No LaTeX content available to export.');
            return; // Retorna vazio para evitar processamento adicional
        }

        // Gerar o arquivo LaTeX com o conteúdo atual do textarea
        $latexContent = $this->description;
        $latexFileName = "project_{$this->projectId}.tex";
        $latexPath = storage_path("app/public/{$latexFileName}");
        file_put_contents($latexPath, $latexContent);

        // Criar o arquivo ZIP
        $zip = new ZipArchive();
        $zipFileName = "project_{$this->projectId}.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $zip->addFile($latexPath, "manuscript.tex");
            $zip->close();
        } else {
            session()->flash('error', 'Could not create ZIP file.');
            return; // Retorna vazio para evitar processamento adicional
        }

        // Tornar o ZIP disponível publicamente
        $publicZipPath = url("storage/{$zipFileName}");

        // Redirecionar o usuário para criar um novo projeto no Overleaf
        $overleafUrl = "https://www.overleaf.com/docs?snip_uri=" . urlencode($publicZipPath);

        // Agendar exclusão dos arquivos após 10 minutos
        DeleteFileLatexJob::dispatch($latexPath, $zipPath)->delay(now()->addMinutes(10));

        // Enviar evento para abrir em nova aba
        $this->dispatch('abrirNovaAba', ['url' => $overleafUrl]);
    }



    public function render()
    {
        return view('livewire.export.latex');
    }


}

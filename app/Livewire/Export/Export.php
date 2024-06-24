<?php

namespace App\Livewire\Export;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Models\Domain as DomainModel;
use App\Models\Keyword as KeywordModel;
use App\Models\ProjectLanguage as ProjectLanguageModel;

class Export extends Component
{
    public $currentProject;
    public $keywordsDescriptions;
    public $template;

 
    public function render()
    {
        return view('livewire.export.export');
    }

    public function mount()
    {
        $projectId = $this->projectSegment();
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->template = $this->overleafTemplate();
        $this->databases = $this->getDatabases();
        // $this->domain = $this->projectDomain();
        // dd($this->domain);
    }

    
    function getDatabases()
    {
        $projectId = $this->currentProject->id;
        $databases = ProjectDatabaseModel::where($projectId, $projectId)->get();
        return $databases;
    } 

    function projectSegment()
    {
        return request()->segment(2);
    }

    function projectDomain()
    {
        $projectId = $this->currentProject->id;
        $domain = DomainModel::where($projectId, $projectId)->pluck('description')->toArray();
        return $domain;
    }


 

    // function projectLanguages()
    // {
    //     $projectId = $this->currentProject->id;
    //     $languages = ProjectLanguageModel::where($projectId, $projectId)->get();
    //     return $languages;
    // }

    function projectOverall()
    {
        $projectId = $this->currentProject->id;
        $project = ProjectModel::where('id', $projectId)->get();
        return $project;
    }

    public function BibTexGenerator()
    {
        $projectName = $this->currentProject->name;
        $projectAuthors = $this->currentProject->authors;
        $projectYear = $this->currentProject->year;

        dd($projectName, $projectAuthors, $projectYear);
    }

    // function projectLanguages()
    // {
    //     $projectId = $this->currentProject->id;
    //     $languages = ProjectLanguageModel::where($projectId, $projectId)->pluck('description')->toArray();
    //     return $languages;
    // }


    public function overleafTemplate()
    {
        $projectName = $this->currentProject->name;
        $databases = $this->getDatabases();
        $projectYear = $this->currentProject->year;
        $projectDescription = $this->currentProject->description;


        $domainArray = $this->projectDomain();
        $domain = implode(', ', $domainArray);
        $author = $this->currentProject->author;  // Adicione a variável autor se disponível
        // $languagearray = $this->projectLanguages();
        // $languages = implode(', ', $languagearray);
        $studyType = $this->currentProject->study_type;
        $keywords = $this->keywordsDescriptions;
        $researchQuestions = $this->currentProject->research_questions;
        $domainsList = 
       
        $latexTemplate = "
        \\documentclass[11pt]{article}
        \\usepackage[utf8]{inputenc}
        \\usepackage{graphicx}
        \\usepackage{booktabs}
        \\usepackage{float}
        \\usepackage[alf]{abntex2cite}
        \\usepackage[brazilian,hyperpageref]{backref}
        \\renewcommand{\\backrefpagesname}{Citado na(s) página(s):~}
        \\renewcommand{\\backref}{}
        \\renewcommand*{\\backrefalt}[4]{
        \\ifcase #1 %
        Nenhuma citação no texto.%
        \\or
        Citado na página #2.%
        \\else
        Citado #1 vezes nas páginas #2.%
        \\fi}%
    
        \\title{{$projectName}}
        \\author{{$author}}
        \\date{{$projectYear}}
    
        \\begin{document}
    
        \\maketitle
    
        \\begin{abstract}
        $projectDescription
        \\end{abstract}
    
        \\section{Planning}
    
        \\subsection{Description}
        $projectDescription
    
        \\subsection{Objectives}
        % Adicione seus objetivos aqui
    
        \\subsection{Domains}
        \\begin{itemize}
            \\item $domain
        \\end{itemize}
    
        \\subsection{Languages}
        \\begin{itemize}
            \\item languages
        \\end{itemize}
    
        \\subsection{Studies Types}
        \\begin{itemize}
            \\item $studyType
        \\end{itemize}
    
        \\subsection{Keywords}
        \\begin{itemize}
            \\item $keywords
        \\end{itemize}
    
        \\subsection{Research Questions}
        \\begin{itemize}
            \\item \\textbf$researchQuestions
        \\end{itemize}
    
        \\subsection{Databases}
        \\begin{table}[!htb]
        \\caption[Databases used at work]{Databases used at work.}
        \\label{tab:databases}
        \\centering
        \\begin{tabular}{@{}ll@{}}
        \\toprule
        \\textbf{Database} & \\textbf{Link} \\\\ \\midrule
        GOOGLE & https://scholar.google.com.br/ \\\\ \\bottomrule 
        \\end{tabular}
        \\end{table}
    
        \\subsection{Terms and Synonyms}
        \\begin{table}[H]
        \\caption[Terms and Synonyms used at work]{Terms and Synonyms used at work.}
        \\label{tab:terms}
        \\centering
        \\begin{tabular}{@{}ll@{}}
        \\toprule
        \\textbf{Term} & \\textbf{Synonyms} \\\\ \\midrule
        \"efeitos da exposição prolongada ao sol em atletas de alto desempenho\" & \\\\ \\bottomrule 
        \\end{tabular}
        \\end{table}
    
        \\subsection{Search Strings}
        \\begin{itemize}
        \\item \\textbf{Generic: }(\"efeitos da exposição prolongada ao sol em atletas de alto desempenho\"); 
        \\item \\textbf{GOOGLE: }(\"efeitos da exposição prolongada ao sol em atletas de alto desempenho\"); 
        \\end{itemize}
    
        \\subsection{Search Strategy}
        % Adicione sua estratégia de pesquisa aqui
    
        \\subsection{Inclusion and Exclusion Criteria}
        Inclusion Rule: Any
    
        \\begin{itemize}
        \\item \\textbf{1: }Example inclusion criterion
        \\end{itemize}
    
        Exclusion Rule: Any
    
        \\begin{itemize}
        \\item \\textbf{1: }Example exclusion criterion
        \\end{itemize}
    
        \\subsection{General Scores}
        Score Minimum to Approve: Example minimum score
    
        \\begin{table}[!htb]
        \\caption[General Scores used at work]{General Scores used at work.}
        \\label{tab:genscores}
        \\centering
        \\begin{tabular}{@{}lll@{}}
        \\toprule
        \\textbf{Start Interval} & \\textbf{End Interval} & \\textbf{Description} \\\\ \\midrule
        3 & 5 & Example description \\\\ \\bottomrule 
        \\end{tabular}
        \\end{table}
    
        \\subsection{Quality Questions}
        \\begin{itemize}
        \\item \\textbf{1: } Example quality question
        \\end{itemize}
    
        \\begin{table}[!htb]
        \\caption[Quality Questions used at work]{Quality Questions used at work.}
        \\label{tab:qa}
        \\centering
        \\begin{tabular}{@{}llll@{}}
        \\toprule
        \\textbf{ID} & \\textbf{Rules} & \\textbf{Weight} & \\textbf{\\begin{tabular}[c]{@{}l@{}}Minimum\\ to\\ Approve\\end{tabular}} \\\\ \\midrule
        1 & \\begin{tabular}[c]{@{}l@{}}Example rule\\ \\end{tabular} & 3 & No minimum \\\\ \\bottomrule 
        \\end{tabular}
        \\end{table}
    
        \\subsection{Extraction Questions}
        \\begin{itemize}
        \\item \\textbf{1: } Example extraction question
        \\end{itemize}
    
        \\begin{table}[!htb]
        \\caption[Extraction Questions used at work]{Extraction Questions used at work.}
        \\label{tab:qe}
        \\centering
        \\begin{tabular}{@{}lll@{}}
        \\toprule
        \\textbf{ID} & \\textbf{Type} & \\textbf{Options} \\\\ \\midrule
        1 & Text & Example options \\\\ \\bottomrule 
        \\end{tabular}
        \\end{table}
    
        \\bibliography{Bib}
    
        \\end{document}
        ";
    
        return $latexTemplate;
    }
    
    

   

    public function generateBibTex()
    {
        $bibTex = '';
        // Verificar qual checkbox está marcada
        if ($this->isChecked('flexCheckDefault1')) {
            // Código para quando o primeiro checkbox estiver marcado
        } else if ($this->isChecked('flexCheckDefault2')) {
            // Código para quando o segundo checkbox estiver marcado
        } else if ($this->isChecked('flexCheckDefault3')) {
            // Código para quando o terceiro checkbox estiver marcado
        } else {
            // Se nenhum checkbox estiver marcado
            $bibTex = $this->template;
        }
        $this->emit('updateBibTex', $bibTex);
    }

    public function downloadAsLatex()
    {
        $text = $this->template;
        // Verifica se o campo está vazio
        if (empty(trim($text))) {
            session()->flash('error-message', 'O campo não pode estar vazio!');
            return;
        } else {
            // Se o campo não estiver vazio, limpa a mensagem de erro
            session()->forget('error-message');
        }
        $filename = "export.bib";
        $headers = [
            'Content-Type' => 'text/plain;charset=utf-8',
        ];
        return response()->streamDownload(function () use ($text) {
            echo $text;
        }, $filename, $headers);
    }

    public function createProjectOnOverleaf()
    {
        $overleafTemplate = $this->overleafTemplate();
        $this->openInOverleaf($overleafTemplate); // Envia o formulário para o Overleaf
    }

    public function openInOverleaf($latexTemplate)
    {
        // Codifica o conteúdo em base64
        $base64Content = base64_encode($latexTemplate);
    
        // Constrói o URL para o Overleaf com os parâmetros necessários
        $overleafUrl = 'https://www.overleaf.com/docs?snip_uri=data:application/x-latex;base64,' . $base64Content;
    
        // Redireciona o usuário para o Overleaf
        return redirect()->away($overleafUrl);
    }
    
    

    private function isChecked($checkboxId)
    {
        // Verifica se a checkbox está marcada
        return $this->get($checkboxId) == 'on';
    }


}

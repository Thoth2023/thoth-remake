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



    public function overleafTemplate()
    {
        $projectName = $this->currentProject->name;
        $databases = $this->getDatabases();
        $projectYear = $this->currentProject->year;
        $projectDescription = $this->currentProject->description;
        $domainArray = $this->projectDomain();
        $domain = implode(', ', $domainArray);
        // $projectKeywords = implode(', ', $this->projectKeywords()->toArray());
        // $projectDomain = implode(', ', $this->projectDomain()->toArray());

        $latexTemplate = "
        \\documentclass{article}
        \\usepackage[utf8]{inputenc}
        \\usepackage{hyperref}
        \\title{{$projectName}}
        
        \\date{{$projectYear}}

        \\begin{document}

        \\maketitle

        \\begin{abstract}
        $projectDescription
        \\end{abstract}

        \\section{Introduction}
        % Write your introduction here

        \\section{Keywords}
       
        \\domains
        $domain

        \\section{Domain}
        

        \\section{Content}
        % Add your content here

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
        $this->generateBibTex(); // Gera o conteúdo LaTeX
        $this->openInOverleaf(); // Envia o formulário para o Overleaf
    }

    public function openInOverleaf()
    {
        // Lógica para abrir no Overleaf
    }

    private function isChecked($checkboxId)
    {
        // Verifica se a checkbox está marcada
        return $this->get($checkboxId) == 'on';
    }


}

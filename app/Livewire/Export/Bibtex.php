<?php

namespace App\Livewire\Export;

use App\Models\Project\Conducting\Papers;
use Livewire\Component;

class Bibtex extends Component
{
    public $projectId;
    public $selectedOption;
    public $description_bibtex = '';

    public function mount($projectId)
    {
        $this->projectId = $projectId;
    }

    public function updatedSelectedOption()
    {
        $this->generateBibtex();
    }

    public function generateBibtex()
    {
        if (!$this->selectedOption) {
            $this->description_bibtex = '';
            return;
        }

        $projectId = $this->projectId;
        $bibtexContent = '';

        if ($this->selectedOption === 'study_selection') {
            $papers = Papers::where('status_selection', 1)
                ->whereHas('bibUpload.projectDatabase', function ($query) use ($projectId) {
                    $query->where('id_project', $projectId);
                })
                ->get();

            foreach ($papers as $paper) {
                $bibtexContent .= $this->formatBibtexEntry($paper);
            }
        } elseif ($this->selectedOption === 'quality_assessment') {
            $papers = Papers::where('status_qa', 1)
                ->whereHas('bibUpload.projectDatabase', function ($query) use ($projectId) {
                    $query->where('id_project', $projectId);
                })
                ->get();

            foreach ($papers as $paper) {
                $bibtexContent .= $this->formatBibtexEntry($paper);
            }
        } elseif ($this->selectedOption === 'snowballing') {
            $bibtexContent = "% No data available for Snowballing.\n";
        } else {
            $bibtexContent = '% No data available for the selected option.';
        }

        $this->description_bibtex = $bibtexContent;
    }

    private function formatBibtexEntry($paper)
    {
        return "@".$paper->type."{" . ($paper->id ) . ",\n" .
            "  title={" . $paper->title . "},\n" .
            "  author={" . $paper->author . "},\n" .
            "  journal={" . ($paper->journal ?? 'N/A') . "},\n" .
            "  year={" . $paper->year . "},\n" .
            "  volume={" . ($paper->volume ?? 'N/A') . "},\n" .
            "  pages={" . ($paper->pages ?? 'N/A') . "},\n" .
            "  doi={" . ($paper->doi ?? 'N/A') . "},\n" .
            "  url={" . ($paper->url ?? 'N/A') . "}\n" .
            "}\n\n";
    }

    public function downloadBibtex()
    {
        if (empty($this->description_bibtex)) {
            session()->flash('error', 'No BibTeX content to download.');
            return;
        }

        $fileName = "project_{$this->projectId}_{$this->selectedOption}.bib";
        $filePath = storage_path("app/{$fileName}");
        file_put_contents($filePath, $this->description_bibtex);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function render()
    {
        return view('livewire.export.bibtex');
    }
}

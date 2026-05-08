<?php

namespace App\Livewire\Export;

use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\PaperSnowballing;
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
            // 1) Pegar papers semente (status_snowballing = 1)
            $seedPapers = Papers::where('status_snowballing', 1)
                ->whereHas('bibUpload.projectDatabase', function ($query) use ($projectId) {
                    $query->where('id_project', $projectId);
                })
                ->get();

            // 2) Para cada paper semente, pegar seus papers relevantes
            foreach ($seedPapers as $seedPaper) {
                // Adiciona o paper semente como cabeçalho
                $bibtexContent .= "\n% ======= PAPER SEMENTE: {$seedPaper->id} =======\n";
                $bibtexContent .= $this->formatBibtexEntry($seedPaper);

                // 3) Pegar papers relevantes deste paper semente, agrupados por tipo
                $relevantPapers = PaperSnowballing::where('paper_reference_id', $seedPaper->id_paper)
                    ->where('is_relevant', true)
                    ->get()
                    ->groupBy('type_snowballing');

                // 4) Exibir backward
                if ($relevantPapers->has('backward')) {
                    $bibtexContent .= "\n% ---- BACKWARD (REFERÊNCIAS) ----\n";
                    foreach ($relevantPapers['backward'] as $ref) {
                        $bibtexContent .= $this->formatPaperSnowballingBibtex($ref);
                    }
                }

                // 5) Exibir forward
                if ($relevantPapers->has('forward')) {
                    $bibtexContent .= "\n% ---- FORWARD (CITAÇÕES) ----\n";
                    foreach ($relevantPapers['forward'] as $ref) {
                        $bibtexContent .= $this->formatPaperSnowballingBibtex($ref);
                    }
                }

                $bibtexContent .= "\n% ======= FIM DO PAPER SEMENTE: {$seedPaper->id} =======\n\n";
            }
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

    private function formatPaperSnowballingBibtex($snowballingPaper)
    {
        // Usar um ID único para cada entrada
        $id = "snowball_{$snowballingPaper->id}";

        return "@article{" . $id . ",\n" .
            "  title={" . ($snowballingPaper->title ?? 'N/A') . "},\n" .
            "  author={" . ($snowballingPaper->authors ?? 'N/A') . "},\n" .
            "  year={" . ($snowballingPaper->year ?? 'N/A') . "},\n" .
            "  doi={" . ($snowballingPaper->doi ?? 'N/A') . "},\n" .
            "  url={" . ($snowballingPaper->url ?? 'N/A') . "},\n" .
            "  source={" . ($snowballingPaper->source ?? 'N/A') . "},\n" .
            "  relevance={" . ($snowballingPaper->relevance_score ?? 'N/A') . "}\n" .
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

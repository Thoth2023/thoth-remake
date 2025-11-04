<?php

namespace App\Livewire\Projects;

use App\Models\Domain;
use App\Models\Keyword;
use App\Models\ProjectDatabase;
use App\Models\ProjectLanguage;
use App\Models\ProjectStudyType;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\SearchStrategy;
use Livewire\Component;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PublicProtocol extends Component
{
    public $project;
    public $showModal = false;
    public $activeTab = 'protocol';

    protected $listeners = ['showPublicProtocol'];

    public function downloadPdf() // cuidado ao mexer nas funções auxiliares deste método, pois são usadas para a formatação do arquivo
    {
        try {
            $project = Project::findOrFail($this->project->id_project);

            $domains        = Domain::where('id_project',$project->id_project)->get();
            $keywords       = Keyword::where('id_project',$project->id_project)->get();
            $languages      = ProjectLanguage::where('id_project',$project->id_project)
                ->join('language','language.id_language','=','project_languages.id_language')
                ->select('language.description')->get();
            $studyTypes     = ProjectStudyType::where('id_project',$project->id_project)
                ->join('study_type','study_type.id_study_type','=','project_study_types.id_study_type')
                ->select('study_type.description')->get();
            $databases      = ProjectDatabase::where('id_project',$project->id_project)
                ->join('data_base','data_base.id_database','=','project_databases.id_database')
                ->select('data_base.name')->get();

            $researchQuestions   = $project->researchQuestions()->get();
            $searchStrategy      = $project->searchStrategy;
            $criteria = $project->criterias()->orderBy('id_criteria')->get();

            $qualityQuestions = Question::with('qualityScores')
                ->where('id_project', $project->id_project)
                ->get();

            $qualityRanges = GeneralScore::where('id_project',$project->id_project)
                ->orderBy('start','asc')->get();

            $qualityCutoff = Cutoff::where('id_project',$project->id_project)->first();

            $extractionQuestions = $project->dataExtractionQuestions()->with('options')->get();

            $publicUrl = "https://thoth-slr.com"; // Somente a home do sistema

            // Bypass Imagick → gerar QR com GD via BaconQrCode
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $qrCodeSvg = $writer->writeString($publicUrl);
            $qrCodeSvgBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);


            $html = view('livewire.projects.public-protocol-pdf', compact(
                'project','domains','keywords','languages','studyTypes','databases',
                'researchQuestions','searchStrategy','criteria',
                'qualityQuestions','qualityRanges','qualityCutoff','extractionQuestions', 'publicUrl', 'qrCodeSvgBase64'
            ))->render();

            $fileName = 'protocolo-'.$this->sanitizeFilename($project->title).'.pdf';
            $pdf = Pdf::loadHTML($html)->setPaper('a4');



            // Footer com paginação/data/título
            $dompdf = $pdf->getDomPDF();
            $canvas = $dompdf->get_canvas();
            $w = $canvas->get_width(); $h = $canvas->get_height();
            $canvas->page_text(36, $h-28, $project->title, null, 8, [0.34,0.34,0.34]);
            $canvas->page_text($w-140, $h-28, date('d-m-y H:i'), null, 8, [0.34,0.34,0.34]);

            return response()->streamDownload(fn()=>print($pdf->output()), $fileName);
        } catch (\Exception $e) {
            Log::error('Erro ao gerar PDF', ['error'=>$e->getMessage()]);
            session()->flash('error', 'Não foi possível gerar o PDF. Por favor, tente novamente.');
            return null;
        }
    }

    protected function sanitizeHtml($html)
    {
        $html = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $html);

        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        return $html;
    }

    protected function sanitizeFilename($filename)
    {

        $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '-', $this->removeAccents($filename));
        $filename = preg_replace('/-+/', '-', $filename); // Remove hífens duplicados
        $filename = trim($filename, '-'); // Remove hífens no início e fim
        return $filename;
    }

    protected function removeAccents($string)
    {
        if (!preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }

        $chars = [
            // Decomposições para Latin-1 Supplement
            'ª' => 'a', 'º' => 'o', 'À' => 'A', 'Á' => 'A',
            'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U',
            'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 'ß' => 's',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'þ' => 'th', 'ÿ' => 'y'
        ];

        return strtr($string, $chars);
    }

    public function mount(Project $project)
    {
        $this->project = $project;
        // Obtém o ID do projeto a partir da URL

        $this->dispatch('setCurrentProjectForChildren', projectId: $project->id_project);
    }

    public function showPublicProtocol()
    {
        $this->showModal = true;
        //$this->dispatch('public-reports-attempt-render');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $searchStrategy = $this->project->searchStrategy()->first();

        return view('livewire.projects.public-protocol', [
            'project' => $this->project,
            'searchStrategy' => $searchStrategy,
        ]);
    }
}

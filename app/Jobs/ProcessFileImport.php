<?php

namespace App\Jobs;

use App\Models\BibUpload;
use App\Utils\NormalizeUTF8;
use Illuminate\Support\Facades\Log;
use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFileImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $projectId;
    protected $database;
    protected $id_bib;
    public $timeout = 300;
    protected $failedEntries = []; // Armazena entradas que falharam na importação

    public function __construct($filePath, $projectId, $database, $id_bib)
    {
        $this->filePath = $filePath;
        $this->projectId = $projectId;
        $this->database = $database;
        $this->id_bib = $id_bib;
    }

    public function handle()
    {
        $contents = file_get_contents($this->filePath);
        $contents = NormalizeUTF8::normalizeString($contents);
        $contents = $this->sanitizeBibtexContent($contents);
        $contents = preg_replace("/\t|[\x{2013}\x{2014}\x{2015}\x{2022}\x{00A0}\x{200B}]/u", " ", $contents);
        $contents = preg_replace_callback('/@(\w+)\{([^,]*)/', function ($matches) {
            $type = $matches[1];
            $identifier = preg_replace('/[^a-zA-Z0-9]/', '_', $matches[2]);
            return "@{$type}{{$identifier}";
        }, $contents);
        $contents = $this->convertLatexSpecialChars($contents);
        $contents = str_replace(["“", "”", "‘", "’"], ['"', '"', "'", "'"], $contents);
        $contents = preg_replace_callback('/note\s*=\s*{([^}]*)}/i', function ($matches) {
            $cleanedNote = str_replace(';', ',', $matches[1]);
            return 'note = {' . $cleanedNote . '}';
        }, $contents);

        $entries = preg_split('/(?=@\w+{)/', $contents, -1, PREG_SPLIT_NO_EMPTY);
        $papers = [];

        foreach ($entries as $entry) {
            $parser = new Parser();
            $listener = new Listener();
            $parser->addListener($listener);

            try {
                $parser->parseString($entry);
                $exportedEntry = $listener->export();
                if (!empty($exportedEntry[0])) {
                    $papers[] = $exportedEntry[0];
                }
            } catch (\Exception $e) {
                Log::error("Erro ao processar entrada BibTeX", [
                    'error' => $e->getMessage(),
                    'entry' => $entry
                ]);
                // Adiciona identificador da entrada que falhou
                if (preg_match('/@(\w+)\{([^,]+)/', $entry, $matches)) {
                    $this->failedEntries[] = $matches[2]; // Salva o identificador que falhou
                }
            }
        }

        if (!empty($papers)) {
            $bibUpload = new BibUpload();
            $bibUpload->importPapers($papers, $this->database, $this->projectId, $this->id_bib);
        }

        // Exibe uma notificação com as entradas que falharam na importação
        if (!empty($this->failedEntries)) {
            $failedIdentifiers = implode(', ', $this->failedEntries);
            session()->flash('import_warning', "As seguintes referências não foram importadas: $failedIdentifiers");
        }
    }

    private function sanitizeBibtexContent($contents)
    {
        $problematicChars = [
            '‐' => '-', '“' => '"', '”' => '"', '‘' => "'", '’' => "'", 'ʇ' => 't'
        ];
        $contents = strtr($contents, $problematicChars);
        $contents = preg_replace_callback('/@(\w+)\{([^,]+)}/', function ($matches) {
            $type = $matches[1];
            $identifier = preg_replace('/[^a-zA-Z0-9]/', '_', $matches[2]);
            return "@{$type}{{$identifier}";
        }, $contents);

        return $contents;
    }

    private function convertLatexSpecialChars($contents)
    {
        $latexToUtf8 = [
            "/\\\\'{a}/" => 'á', "/\\\\'{e}/" => 'é', "/\\\\'{i}/" => 'í', "/\\\\'{o}/" => 'ó', "/\\\\'{u}/" => 'ú',
            "/\\\\'{y}/" => 'ý', "/\\\\'{A}/" => 'Á', "/\\\\'{E}/" => 'É', "/\\\\'{I}/" => 'Í', "/\\\\'{O}/" => 'Ó',
            "/\\\\'{U}/" => 'Ú', "/\\\\'{Y}/" => 'Ý', "/\\\\`{a}/" => 'à', "/\\\\`{e}/" => 'è', "/\\\\`{i}/" => 'ì',
            "/\\\\`{o}/" => 'ò', "/\\\\`{u}/" => 'ù', "/\\\\`{A}/" => 'À', "/\\\\`{E}/" => 'È', "/\\\\`{I}/" => 'Ì',
            "/\\\\`{O}/" => 'Ò', "/\\\\`{U}/" => 'Ù', "/\\\\\\^{a}/" => 'â', "/\\\\\\^{e}/" => 'ê', "/\\\\\\^{i}/" => 'î',
            "/\\\\\\^{o}/" => 'ô', "/\\\\\\^{u}/" => 'û', "/\\\\\\^{A}/" => 'Â', "/\\\\\\^{E}/" => 'Ê', "/\\\\\\^{I}/" => 'Î',
            "/\\\\\\^{O}/" => 'Ô', "/\\\\\\^{U}/" => 'Û', "/\\\\\"{a}/" => 'ä', "/\\\\\"{e}/" => 'ë', "/\\\\\"{i}/" => 'ï',
            "/\\\\\"{o}/" => 'ö', "/\\\\\"{u}/" => 'ü', "/\\\\\"{y}/" => 'ÿ', "/\\\\\"{A}/" => 'Ä', "/\\\\\"{E}/" => 'Ë',
            "/\\\\\"{I}/" => 'Ï', "/\\\\\"{O}/" => 'Ö', "/\\\\\"{U}/" => 'Ü', "/\\\\~{n}/" => 'ñ', "/\\\\~{a}/" => 'ã',
            "/\\\\~{o}/" => 'õ', "/\\\\~{N}/" => 'Ñ', "/\\\\~{A}/" => 'Ã', "/\\\\~{O}/" => 'Õ', "/\\\\c{c}/" => 'ç',
            "/\\\\c{C}/" => 'Ç', "/\\\\ss/" => 'ß', "/\\\\ae/" => 'æ', "/\\\\AE/" => 'Æ', "/\\\\oe/" => 'œ', "/\\\\OE/" => 'Œ',
            "/\\\\aa/" => 'å', "/\\\\AA/" => 'Å', "/\\\\pm/" => '±', "/\\\\times/" => '×', "/\\\\div/" => '÷',
            "/\\\\infty/" => '∞', "/\\\\alpha/" => 'α', "/\\\\beta/" => 'β', "/\\\\gamma/" => 'γ', "/\\\\delta/" => 'δ',
            "/\\\\epsilon/" => 'ε', "/\\\\zeta/" => 'ζ', "/\\\\eta/" => 'η', "/\\\\theta/" => 'θ', "/\\\\lambda/" => 'λ',
            "/\\\\mu/" => 'μ', "/\\\\pi/" => 'π', "/\\\\phi/" => 'φ', "/\\\\rho/" => 'ρ', "/\\\\sigma/" => 'σ',
            "/\\\\tau/" => 'τ', "/\\\\chi/" => 'χ', "/\\\\psi/" => 'ψ', "/\\\\omega/" => 'ω', "/\\\\Gamma/" => 'Γ',
            "/\\\\Delta/" => 'Δ', "/\\\\Theta/" => 'Θ', "/\\\\Lambda/" => 'Λ', "/\\\\Xi/" => 'Ξ', "/\\\\Pi/" => 'Π',
            "/\\\\Sigma/" => 'Σ', "/\\\\Upsilon/" => 'Υ', "/\\\\Phi/" => 'Φ', "/\\\\Psi/" => 'Ψ', "/\\\\Omega/" => 'Ω',
            "/\\\\degree/" => '°', "/\\\\copyright/" => '©', "/\\\\pounds/" => '£', "/\\\\euro/" => '€',
            "/\\\\'{c}/" => 'ć', "/\\\\'{C}/" => 'Ć', "/\\\\v{s}/" => 'š', "/\\\\v{S}/" => 'Š', "/\\\\v{z}/" => 'ž',
            "/\\\\v{Z}/" => 'Ž', "/\\\\v{c}/" => 'č', "/\\\\v{C}/" => 'Č', "/\\\\v{r}/" => 'ř', "/\\\\v{R}/" => 'Ř',
            "/\\\\v{e}/" => 'ě', "/\\\\v{E}/" => 'Ě'
        ];

        foreach ($latexToUtf8 as $latex => $utf8) {
            $contents = preg_replace($latex, $utf8, $contents);
        }

        return $contents;
    }
}

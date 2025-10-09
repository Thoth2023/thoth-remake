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

        //Detectar e converter encoding automaticamente
        $encoding = mb_detect_encoding($contents, ['UTF-8', 'ISO-8859-1', 'Windows-1252', 'ASCII'], true);
        if ($encoding !== 'UTF-8') {
            $contents = mb_convert_encoding($contents, 'UTF-8', $encoding);
            Log::info("Arquivo {$this->filePath} convertido de {$encoding} para UTF-8.");
        }

        //Normalizar e limpar caracteres problemáticos
        $contents = NormalizeUTF8::normalizeString($contents);
        $contents = $this->sanitizeBibtexContent($contents);
        $contents = preg_replace("/\t|[\x{2013}\x{2014}\x{2015}\x{2022}\x{00A0}\x{200B}]/u", " ", $contents);
        $contents = preg_replace_callback('/@(\w+)\{([^,]*)/', function ($matches) {
            $type = $matches[1];
            $identifier = preg_replace('/[^a-zA-Z0-9]/', '_', $matches[2]);
            return "@{$type}{{$identifier}";
        }, $contents);
        $contents = $this->convertLatexSpecialChars($contents);
        $contents = $this->cleanBibtexFieldValues($contents);
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

    private function cleanBibtexFieldValues(string $contents): string
    {
        // Remove aspas tipográficas e converte para aspas padrão
        $contents = str_replace(['„', '“', '”', '“', '‟'], '"', $contents);
        $contents = str_replace(["''", '``', '„'], '"', $contents);

        // Limpa vírgulas e aspas no início ou final de campos
        $contents = preg_replace_callback('/=\s*{([^}]*)}/', function ($matches) {
            $value = trim($matches[1]);

            // Remove vírgulas e aspas duplicadas do início e fim
            $value = preg_replace('/^[,"\s]+|[,"\s]+$/u', '', $value);

            return '= {' . $value . '}';
        }, $contents);

        return $contents;
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
            // Acentos com chaves (padrão BibTeX)
            "/\\\\'{a}/u" => 'á', "/\\\\'{e}/u" => 'é', "/\\\\'{i}/u" => 'í', "/\\\\'{o}/u" => 'ó', "/\\\\'{u}/u" => 'ú',
            "/\\\\'{y}/u" => 'ý', "/\\\\'{A}/u" => 'Á', "/\\\\'{E}/u" => 'É', "/\\\\'{I}/u" => 'Í', "/\\\\'{O}/u" => 'Ó',
            "/\\\\'{U}/u" => 'Ú', "/\\\\'{Y}/u" => 'Ý', "/\\\\`{a}/u" => 'à', "/\\\\`{e}/u" => 'è', "/\\\\`{i}/u" => 'ì',
            "/\\\\`{o}/u" => 'ò', "/\\\\`{u}/u" => 'ù', "/\\\\`{A}/u" => 'À', "/\\\\`{E}/u" => 'È', "/\\\\`{I}/u" => 'Ì',
            "/\\\\`{O}/u" => 'Ò', "/\\\\`{U}/u" => 'Ù', "/\\\\\\^{a}/u" => 'â', "/\\\\\\^{e}/u" => 'ê', "/\\\\\\^{i}/u" => 'î',
            "/\\\\\\^{o}/u" => 'ô', "/\\\\\\^{u}/u" => 'û', "/\\\\\\^{A}/u" => 'Â', "/\\\\\\^{E}/u" => 'Ê', "/\\\\\\^{I}/u" => 'Î',
            "/\\\\\\^{O}/u" => 'Ô', "/\\\\\\^{U}/u" => 'Û', "/\\\\\"{a}/u" => 'ä', "/\\\\\"{e}/u" => 'ë', "/\\\\\"{i}/u" => 'ï',
            "/\\\\\"{o}/u" => 'ö', "/\\\\\"{u}/u" => 'ü', "/\\\\\"{y}/u" => 'ÿ', "/\\\\\"{A}/u" => 'Ä', "/\\\\\"{E}/u" => 'Ë',
            "/\\\\\"{I}/u" => 'Ï', "/\\\\\"{O}/u" => 'Ö', "/\\\\\"{U}/u" => 'Ü', "/\\\\~{n}/u" => 'ñ', "/\\\\~{a}/u" => 'ã',
            "/\\\\~{o}/u" => 'õ', "/\\\\~{N}/u" => 'Ñ', "/\\\\~{A}/u" => 'Ã', "/\\\\~{O}/u" => 'Õ', "/\\\\c{c}/u" => 'ç',
            "/\\\\c{C}/u" => 'Ç',

            // Versões LaTeX com chaves duplas {\'a}, {\~o}, etc.
            "/\{\\\\'{a}\}/u" => 'á', "/\{\\\\'{e}\}/u" => 'é', "/\{\\\\'{i}\}/u" => 'í', "/\{\\\\'{o}\}/u" => 'ó',
            "/\{\\\\'{u}\}/u" => 'ú', "/\{\\\\~{a}\}/u" => 'ã', "/\{\\\\~{o}\}/u" => 'õ', "/\{\\\\~{n}\}/u" => 'ñ',
            "/\{\\\\c{c}\}/u" => 'ç', "/\{\\\\`{a}\}/u" => 'à', "/\{\\\\`{e}\}/u" => 'è', "/\{\\\\`{i}\}/u" => 'ì',
            "/\{\\\\`{o}\}/u" => 'ò', "/\{\\\\`{u}\}/u" => 'ù',

            // Versões sem chaves (\~o, \'a etc.)
            "/\\\\~o/u" => 'õ', "/\\\\~a/u" => 'ã', "/\\\\~n/u" => 'ñ',
            "/\\\\'a/u" => 'á', "/\\\\'e/u" => 'é', "/\\\\'i/u" => 'í', "/\\\\'o/u" => 'ó', "/\\\\'u/u" => 'ú',
            "/\\\\`a/u" => 'à', "/\\\\`e/u" => 'è', "/\\\\`i/u" => 'ì', "/\\\\`o/u" => 'ò', "/\\\\`u/u" => 'ù',
            "/\\\\\^a/u" => 'â', "/\\\\\^e/u" => 'ê', "/\\\\\^i/u" => 'î', "/\\\\\^o/u" => 'ô', "/\\\\\^u/u" => 'û',
            "/\\\\c c/u" => 'ç',

            // acentos aplicados a \i (i sem ponto) ---
            // {\'\i}, {\`\i}, {^\i}, {"\i}
            "/\{\\\\'\\\\i\}/u"     => 'í',
            "/\{\\\\`\\\\i\}/u"     => 'ì',
            "/\{\\\\\\^\\\\i\}/u"   => 'î',
            "/\{\\\\".'"'."\\\\i\}/u" => 'ï',

            // \'{\i}, \`{\i}, \^{\i}, \"{\i}
            "/\\\\'\\{\\\\i\\}/u"     => 'í',
            "/\\\\`\\{\\\\i\\}/u"     => 'ì',
            "/\\\\\\^\\{\\\\i\\}/u"   => 'î',
            "/\\\\".'"'."\\{\\\\i\\}/u" => 'ï',

            // Símbolos e caracteres extras
            "/\\\\ss/u" => 'ß', "/\\\\ae/u" => 'æ', "/\\\\AE/u" => 'Æ', "/\\\\oe/u" => 'œ', "/\\\\OE/u" => 'Œ',
            "/\\\\degree/u" => '°', "/\\\\copyright/u" => '©', "/\\\\pounds/u" => '£', "/\\\\euro/u" => '€',
        ];

        foreach ($latexToUtf8 as $latex => $utf8) {
            $contents = preg_replace($latex, $utf8, $contents);
        }

        // Remove caracteres invisíveis e de controle
        $contents = preg_replace('/[\x00-\x1F\x7F]/u', '', $contents);

        // Remove chaves redundantes {A} -> A
        $contents = preg_replace('/\{\s*([A-Za-zÀ-ÿ])\s*\}/u', '$1', $contents);

        // Remove aspas duplas ou vírgulas sobrando no início/fim
        $contents = preg_replace('/^[\s",]+|[\s",]+$/u', '', $contents);

        return $contents;
    }

}

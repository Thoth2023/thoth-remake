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

    public function __construct($filePath, $projectId, $database, $id_bib)
    {
        $this->filePath = $filePath;
        $this->projectId = $projectId;
        $this->database = $database;
        $this->id_bib = $id_bib;
    }

    public function handle()
    {
        // Carregar o conteúdo do arquivo
        $contents = file_get_contents($this->filePath);

        // Normalizar o conteúdo para UTF-8 usando a classe utilitária
        $contents = NormalizeUTF8::normalizeString($contents);

        //Log::info("Conteúdo original antes da sanitização", ['contents' => $contents]);
        // Substituir caracteres problemáticos
        $contents = $this->sanitizeBibtexContent($contents);

        //Log::info("Conteúdo após a sanitização", ['contents' => $contents]);

        // Limpeza de caracteres especiais e formatação BibTeX
        $contents = preg_replace("/\t|[\x{2013}\x{2014}\x{2015}\x{2022}\x{00A0}\x{200B}]/u", " ", $contents);

        // Normalizar identificadores para evitar erros com espaços
        $contents = preg_replace_callback('/@(\w+)\{([^,]*)/', function ($matches) {
            $type = $matches[1];
            // Substitui espaços e apóstrofos por underscores
            $identifier = preg_replace(['/[\s\']+/'], '_', $matches[2]);
            return "@{$type}{{$identifier}";
        }, $contents);

        // Substituir escapes LaTeX para caracteres UTF-8
        $contents = $this->convertLatexSpecialChars($contents);

        // Substituir aspas e apóstrofos estilizados por versões simples
        $contents = str_replace(
            ["“", "”", "‘", "’"],
            ['"', '"', "'", "'"],
            $contents
        );

        // Remover ou substituir o ponto e vírgula no campo note
        $contents = preg_replace_callback('/note\s*=\s*{([^}]*)}/i', function ($matches) {
            $cleanedNote = str_replace(';', ',', $matches[1]);
            return 'note = {' . $cleanedNote . '}';
        }, $contents);

        // Dividir o conteúdo por entradas @<tipo>{ para obter cada referência individualmente
        $entries = preg_split('/(?=@\w+{)/', $contents, -1, PREG_SPLIT_NO_EMPTY);

        $papers = [];
        foreach ($entries as $entry) {
            $parser = new Parser();
            $listener = new Listener();
            $parser->addListener($listener);

            try {
                // Processar cada entrada individualmente
                $parser->parseString($entry);

                // Obter a exportação do Listener
                $exportedEntry = $listener->export();

                // Adicionar a entrada exportada à lista de papers
                if (!empty($exportedEntry[0])) {
                    $papers[] = $exportedEntry[0];
                }
            } catch (\Exception $e) {
                // Log de erro detalhado para falhas de parsing
                Log::error("Erro ao processar entrada BibTeX", [
                    'error' => $e->getMessage(),
                    'entry' => $entry
                ]);
            }
        }

        // Importar as referências capturadas usando o método importPapers
        if (!empty($papers)) {
            $bibUpload = new BibUpload();
            $bibUpload->importPapers($papers, $this->database, $this->projectId, $this->id_bib);
        }
    }

    private function sanitizeBibtexContent($contents)
    {
        // Mapeamento de caracteres problemáticos para alternativas mais comuns
        $problematicChars = [
            '‐' => '-', // hífen
            '“' => '"', '”' => '"',  // aspas duplas estilizadas
            '‘' => "'", '’' => "'",  // aspas simples estilizadas
            'ʇ' => 't',              // exemplo de substituição para o caractere 'ʇ'
        ];

        // Substituir os caracteres
        return strtr($contents, $problematicChars);
    }

    /**
     * Função para converter caracteres especiais do LaTeX para UTF-8.
     *
     * @param string $contents
     * @return string
     */
    private function convertLatexSpecialChars($contents)
    {
        // Mapeamento de caracteres LaTeX para UTF-8
        $latexToUtf8 = [
            // Letras minúsculas com acento agudo
            "/\\\\'{a}/" => 'á', "/\\\\'{e}/" => 'é', "/\\\\'{i}/" => 'í', "/\\\\'{o}/" => 'ó', "/\\\\'{u}/" => 'ú',
            "/\\\\'{y}/" => 'ý',

            // Letras maiúsculas com acento agudo
            "/\\\\'{A}/" => 'Á', "/\\\\'{E}/" => 'É', "/\\\\'{I}/" => 'Í', "/\\\\'{O}/" => 'Ó', "/\\\\'{U}/" => 'Ú',
            "/\\\\'{Y}/" => 'Ý',

            // Letras minúsculas com acento grave
            "/\\\\`{a}/" => 'à', "/\\\\`{e}/" => 'è', "/\\\\`{i}/" => 'ì', "/\\\\`{o}/" => 'ò', "/\\\\`{u}/" => 'ù',

            // Letras maiúsculas com acento grave
            "/\\\\`{A}/" => 'À', "/\\\\`{E}/" => 'È', "/\\\\`{I}/" => 'Ì', "/\\\\`{O}/" => 'Ò', "/\\\\`{U}/" => 'Ù',

            // Letras minúsculas com acento circunflexo
            "/\\\\\\^{a}/" => 'â', "/\\\\\\^{e}/" => 'ê', "/\\\\\\^{i}/" => 'î', "/\\\\\\^{o}/" => 'ô', "/\\\\\\^{u}/" => 'û',

            // Letras maiúsculas com acento circunflexo
            "/\\\\\\^{A}/" => 'Â', "/\\\\\\^{E}/" => 'Ê', "/\\\\\\^{I}/" => 'Î', "/\\\\\\^{O}/" => 'Ô', "/\\\\\\^{U}/" => 'Û',

            // Letras com trema
            "/\\\\\"{a}/" => 'ä', "/\\\\\"{e}/" => 'ë', "/\\\\\"{i}/" => 'ï', "/\\\\\"{o}/" => 'ö', "/\\\\\"{u}/" => 'ü',
            "/\\\\\"{y}/" => 'ÿ',

            "/\\\\\"{A}/" => 'Ä', "/\\\\\"{E}/" => 'Ë', "/\\\\\"{I}/" => 'Ï', "/\\\\\"{O}/" => 'Ö', "/\\\\\"{U}/" => 'Ü',

            // Til
            "/\\\\~{n}/" => 'ñ', "/\\\\~{a}/" => 'ã', "/\\\\~{o}/" => 'õ',
            "/\\\\~{N}/" => 'Ñ', "/\\\\~{A}/" => 'Ã', "/\\\\~{O}/" => 'Õ',

            // Cedilha
            "/\\\\c{c}/" => 'ç', "/\\\\c{C}/" => 'Ç',

            // Outros caracteres especiais
            "/\\\\ss/" => 'ß',  // Eszett (beta alemão)
            "/\\\\ae/" => 'æ', "/\\\\AE/" => 'Æ',  // AE minúsculo e maiúsculo
            "/\\\\oe/" => 'œ', "/\\\\OE/" => 'Œ',  // OE minúsculo e maiúsculo
            "/\\\\aa/" => 'å', "/\\\\AA/" => 'Å',  // AA minúsculo e maiúsculo

            // Símbolos matemáticos e especiais
            "/\\\\pm/" => '±',  // Mais ou menos
            "/\\\\times/" => '×',  // Multiplicação
            "/\\\\div/" => '÷',  // Divisão
            "/\\\\infty/" => '∞',  // Infinito
            "/\\\\alpha/" => 'α', "/\\\\beta/" => 'β', "/\\\\gamma/" => 'γ', "/\\\\delta/" => 'δ',
            "/\\\\epsilon/" => 'ε', "/\\\\zeta/" => 'ζ', "/\\\\eta/" => 'η', "/\\\\theta/" => 'θ',
            "/\\\\lambda/" => 'λ', "/\\\\mu/" => 'μ', "/\\\\pi/" => 'π', "/\\\\phi/" => 'φ',
            "/\\\\rho/" => 'ρ', "/\\\\sigma/" => 'σ', "/\\\\tau/" => 'τ', "/\\\\chi/" => 'χ', "/\\\\psi/" => 'ψ',
            "/\\\\omega/" => 'ω',

            // Letras gregas maiúsculas
            "/\\\\Gamma/" => 'Γ', "/\\\\Delta/" => 'Δ', "/\\\\Theta/" => 'Θ', "/\\\\Lambda/" => 'Λ',
            "/\\\\Xi/" => 'Ξ', "/\\\\Pi/" => 'Π', "/\\\\Sigma/" => 'Σ', "/\\\\Upsilon/" => 'Υ',
            "/\\\\Phi/" => 'Φ', "/\\\\Psi/" => 'Ψ', "/\\\\Omega/" => 'Ω',

            // Símbolos diversos
            "/\\\\degree/" => '°',  // Grau
            "/\\\\copyright/" => '©',
            "/\\\\pounds/" => '£',
            "/\\\\euro/" => '€',

            // Outras combinações com acentos
            "/\\\\'{c}/" => 'ć', "/\\\\'{C}/" => 'Ć',
            "/\\\\v{s}/" => 'š', "/\\\\v{S}/" => 'Š', "/\\\\v{z}/" => 'ž', "/\\\\v{Z}/" => 'Ž',
            "/\\\\v{c}/" => 'č', "/\\\\v{C}/" => 'Č', "/\\\\v{r}/" => 'ř', "/\\\\v{R}/" => 'Ř',
            "/\\\\v{e}/" => 'ě', "/\\\\v{E}/" => 'Ě',
        ];

        // Aplicar substituições no conteúdo
        foreach ($latexToUtf8 as $latex => $utf8) {
            $contents = preg_replace($latex, $utf8, $contents);
        }

        return $contents;
    }


}

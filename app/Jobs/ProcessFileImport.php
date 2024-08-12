<?php

namespace App\Jobs;

use App\Models\BibUpload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use RenanBr\BibTexParser\Exception\ParserException;
use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;

class ProcessFileImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;
    public $fileName;
    public $id_project_database;
    public $id_project;
    public $database;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath, $fileName, $id_project_database, $id_project, $database)
    {
        $this->filePath = $filePath;
        $this->fileName = $fileName;
        $this->id_project_database = $id_project_database;
        $this->id_project = $id_project;
        $this->database = $database;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $extension = pathinfo($this->fileName, PATHINFO_EXTENSION);

            $papers = in_array($extension, ['bib', 'txt']) ? $this->extractBibTexReferences($this->filePath) : $this->extractCsvReferences($this->filePath);

            $bibUpload = BibUpload::create([
                'name' => $this->fileName,
                'id_project_database' => $this->id_project_database,
            ]);

            $papersInserted = $bibUpload->importPapers($papers, $this->database, $this->id_project);

            // Log activity, if needed
            // Log::logActivity(....);

            // Perform any additional actions or notifications if needed

        } catch (\Exception $e) {
            // Handle exceptions
        }
    }

    private function extractBibTexReferences($filePath)
    {
        $parser = new Parser();
        $listener = new Listener();
        $parser->addListener($listener);

        $handle = fopen($filePath, 'r');
        if ($handle !== false) {
            while (($line = fgets($handle)) !== false) {
                $parser->parseString($line);
            }
            fclose($handle);
        }

        return $listener->export();
    }

    private function extractCsvReferences($filePath)
    {
        $csv = array_map('str_getcsv', file($filePath));
        $header = array_shift($csv);
        $papers = [];

        foreach ($csv as $row) {
            if (count($row) === count($header)) {
                $csvRow = array_combine($header, $row);
                $mappedRow = $this->mapCsvFields($csvRow);
                $papers[] = $mappedRow;
            }
        }

        return $papers;
    }

    private function mapCsvFields($csvRow)
    {
        return [
            'type' => $csvRow['Content Type'] ?? '',
            'citation-key' => '',
            'title' => $csvRow['Item Title'] ?? '',
            'author' => $csvRow['Authors'] ?? '',
            'booktitle' => $csvRow['Book Series Title'] ?? '',
            'volume' => $csvRow['Journal Volume'] ?? '',
            'pages' => '',
            'numpages' => '',
            'abstract' => '',
            'keywords' => '',
            'doi' => $csvRow['Item DOI'] ?? '',
            'journal' => $csvRow['Publication Title'] ?? '',
            'issn' => '',
            'location' => '',
            'isbn' => '',
            'address' => '',
            'url' => $csvRow['URL'] ?? '',
            'publisher' => '',
            'year' => $csvRow['Publication Year'] ?? '',
        ];
    }
}

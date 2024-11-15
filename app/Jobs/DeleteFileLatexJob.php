<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DeleteFileLatexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath Caminho do arquivo a ser excluído.
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (File::exists($this->filePath)) {
            try {
                File::delete($this->filePath);
                Log::info("File deleted: {$this->filePath}");
            } catch (\Exception $e) {
                Log::error("Error deleting file {$this->filePath}: " . $e->getMessage());
            }
        } else {
            Log::warning("File not found for deletion: {$this->filePath}");
        }
    }
}

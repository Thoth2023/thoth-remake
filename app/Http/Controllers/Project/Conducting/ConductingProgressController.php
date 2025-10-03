<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Services\ConductingProgressService;


class ConductingProgressController
{
    protected ConductingProgressService $progressService;

    public function __construct(ConductingProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function calculateProgress($projectId)
    {
        return $this->progressService->calculateProgress($projectId);
    }
}

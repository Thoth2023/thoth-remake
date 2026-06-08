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
        dd([
            'project_id' => $projectId,
            'auth_id' => auth()->id(),
            'member' => \App\Models\Member::where('id_project', $projectId)
                ->where('id_user', auth()->id())
                ->get()
        ]);
        //return $this->progressService->calculateProgress($projectId, auth()->id());
    }
}

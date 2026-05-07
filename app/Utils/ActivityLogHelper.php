<?php

namespace App\Utils;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogHelper
{
    public static function insertActivityLog($activity, $id_module, $id_project, $id_user = null)
    {

    Activity::create([
    'activity' => $activity,
    'id_module' => $id_module,
       'id_project' => $id_project,
     'id_user' => Auth::id(),
    ]);

    }

    public static function logActivity(string $action, string $description, string $module, string $projectId, string $userId = null): void
    {
        $activity = $action . " " . $description;

        ActivityLogHelper::insertActivityLog(
            activity: $activity,
            id_module: $module,
            id_project: $projectId,
            id_user: $userId ?? Auth::user()->id
        );
    }
}

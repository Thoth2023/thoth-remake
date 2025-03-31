<?php

namespace App\Utils;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogHelper
{
    public static function insertActivityLog($activity, $id_module, $id_project, $id_user = null)
    {
       
    // Desativado temporariamente por falta de módulo no banco
    // Activity::create([
    //     'activity' => $descricao,
    //     'id_module' => 1,
    //     'id_project' => $idProjeto,
    //     'id_user' => Auth::id(),
    // ]);

    }
    
    public static function logActivity(string $action, string $description, string $projectId, string $userId = null): void
    {
        $activity = $action . " " . $description;

        ActivityLogHelper::insertActivityLog(
            activity: $activity,
            id_module: 1,
            id_project: $projectId,
            id_user: $userId ?? Auth::user()->id
        );
    }
}

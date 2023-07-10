<?php

namespace App\Utils;
use App\Models\Activity;

class ActivityLogHelper
{
    public static function insertActivityLog($activity, $id_module, $id_project, $id_user)
    {
        Activity::create([
            'activity' => $activity,
            'id_module' => $id_module,
            'id_project' => $id_project,
            'id_user' => $id_user,
        ]);
    }
}
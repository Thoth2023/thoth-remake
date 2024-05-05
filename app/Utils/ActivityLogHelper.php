<?php

namespace App\Utils;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogHelper
{
    public static function insertActivityLog($activity, $id_module, $id_project, $id_user = null)
    {
        Activity::create([
            'activity' => $activity,
            'id_module' => $id_module,
            'id_project' => $id_project,
            'id_user' => $id_user ?? Auth::user()->id,
        ]);
    }
}

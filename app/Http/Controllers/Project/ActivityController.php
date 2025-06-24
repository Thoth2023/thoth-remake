<?php
namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Utils\ActivityLogHelper;

class ActivityController extends Controller
{
    public function export($projectId)
    {
        return (new ActivityLogHelper())->exportActivities($projectId);
    }
}
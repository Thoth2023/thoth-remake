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
       
    //Activity::create([
    //'activity' => $descricao,
    //'id_module' => 1,
       //'id_project' => $idProjeto,
     //'id_user' => Auth::id(),
    //]);

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

    public function exportActivities($projectId)
    {
        $project = Project::findOrFail($projectId);
        $activities = \App\Models\Activity::where('id_project', $projectId)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=activities.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['User', 'Activity', 'Date'];

        $callback = function() use ($activities, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->user->username ?? '',
                    $activity->activity,
                    $activity->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

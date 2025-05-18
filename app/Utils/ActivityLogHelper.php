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
        if (is_array($activity)) {
            $activityKey = $activity['key'];
            $activityParams = json_encode($activity['params']);
        } else {
            $activityKey = $activity;
            $activityParams = null;
        }

        Activity::create([
            'activity' => $activityKey,
            'activity_params' => $activityParams,
            'id_module' => $id_module,
            'id_project' => $id_project,
            'id_user' => $id_user ?? Auth::user()->id,
        ]);
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

        $locale = app()->getLocale();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=activities.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = [
        __('project/overview.user'),
        __('project/overview.activity'),
        __('project/overview.date'),
        ];

        $callback = function() use ($activities, $columns, $locale) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($activities as $activity) {
            $date = \Carbon\Carbon::parse($activity->created_at)->locale($locale);
            $format = ($locale === 'pt_BR' || $locale === 'pt') ? 'd/m/Y H:i:s' : 'm/d/Y h:i:s A';

            $params = $activity->activity_params ? json_decode($activity->activity_params, true) : [];
            $translatedActivity = __(
                'project/overview.'.$activity->activity,
                $params
            );

            fputcsv($file, [
                $activity->user->username ?? '',
                $translatedActivity,
                $date->translatedFormat($format),
            ]);
        }
        fclose($file);
    };

        return response()->stream($callback, 200, $headers);
    }
}

<?php

/**
 * File: DateController.php
 * Author: Auri Gabriel
 *
 * Description: This controller is responsible for adding and updating a date to a project.
 *              It was created as a result of refactoring from the older controller
 *              PlanningOverallInformationController.php, which had too many responsibilities,
 *              was getting too long and hard to maintain.
 *
 * Date: 2024-03-09
 *
 * @see Project
 */

namespace App\Http\Controllers\Project\Planning\Overall;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Project\Planning\PlanningProgressController;
use App\Http\Requests\DateUpdateRequest;
use App\Models\Project;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DateController extends Controller
{
    /**
     * Add date to a project.
     *
     * @param  DateUpdateRequest  $request
     * @param  string  $projectId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addDate(DateUpdateRequest $request, string $projectId): RedirectResponse
    {
        $project = Project::findOrFail($projectId);

        if (!$project) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'overall-info')
                ->with('error', 'Project not found');
        }

        if ($request->start_date > $request->end_date) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'overall-info')
                ->with('error', 'Start date cannot be greater than end date');
        }

        $project->addDate(
            startDate: $request->start_date,
            endDate: $request->end_date
        );

        $this->logActivity(
            activity: 'Project date added: ' . $request->start_date . ' - ' . $request->end_date,
            id_project: $projectId
        );

        $progress = app(PlanningProgressController::class)->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Date added successfully')
            ->with('progress', $progress);
    }

    /**
     * Log activity for the specified project.
     *
     * @param  string  $activity
     * @param  string  $id_project
     * @return void
     */
    private function logActivity(string $activity, string $id_project)
    {
        ActivityLogHelper::insertActivityLog(
            activity: $activity,
            id_module: 1,
            id_project: $id_project,
            id_user: Auth::id()
        );
    }
}

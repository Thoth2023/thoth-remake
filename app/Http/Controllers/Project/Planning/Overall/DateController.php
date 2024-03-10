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
use App\Http\Requests\DateUpdateRequest;
use App\Models\Project;
use App\Utils\ActivityLogHelper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $project = Project::findOrFail($projectId);
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with('error', 'Project not found');
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $this->validateDateRange($startDate, $endDate);

        $project->addDate($startDate, $endDate);

        $activity = "Added the start date " . $project->start_date . " and end date " . $project->end_date;
        $this->logActivity($activity, $project->id_project);

        return redirect()
            ->back()
            ->with('success', 'Date added successfully');
    }

    /**
     * Validate the date range.
     *
     * @param  string  $startDate
     * @param  string  $endDate
     * @return void
     */
    private function validateDateRange($startDate, $endDate): void
    {
        $rules = [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];

        $customMessages = [
            'end_date.after' => 'The end date must be after the start date.',
        ];

        $this->validate(request(), $rules, $customMessages);
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
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
    }
}

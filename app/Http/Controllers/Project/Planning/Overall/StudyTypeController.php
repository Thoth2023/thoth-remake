<?php

/**
 * File: StudyTypeController.php
 * Author: Auri Gabriel
 *
 * Description: This controller is responsible for handling the study types for a project.
 *              It was created as a result of refactoring from the older controller
 *              PlanningOverallInformationController.php, which had too many responsibilities,
 *              was getting too long and hard to maintain.
 *
 * Date: 2024-03-09
 *
 * @see StudyType, Project, ProjectStudyType
 */

namespace App\Http\Controllers\Project\Planning\Overall;

use App\Http\Requests\StudyTypeUpdateRequest;
use App\Models\StudyType;
use App\Models\ProjectStudyType;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class StudyTypeController extends Controller
{
    /**
     * Add a study type to the project.
     *
     * @param  StudyTypeUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudyTypeUpdateRequest $request): RedirectResponse
    {
        $projectStudyType = ProjectStudyType::firstOrNew([
            'id_project' => $request->id_project,
            'id_study_type' => $request->id_study_type,
        ]);

        if ($projectStudyType->exists) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'overall-info')
                ->withErrors([
                    'duplicate' => 'The provided study type already exists in this project.',
                ]);
        }

        $projectStudyType->save();

        $studyType = StudyType::findOrFail($request->id_study_type);
        $id_project = $request->id_project;

        $this->logActivity(
            action: 'Added a study type',
            description: $studyType->description,
            id_project: $id_project
        );

        $progress = app(PlanningProgressController::class)->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Study type added to the project')
            ->with('progress', $progress);
    }

    /**
     * Remove the specified study type from the project.
     *
     * @param  string  $projectId
     * @param string $studyTypeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $projectId, string $studyTypeId): RedirectResponse
    {
        $projectStudyType = ProjectStudyType::where('id_project', $projectId)
            ->where('id_study_type', $studyTypeId)
            ->first();

        $projectStudyType->delete();

        $this->logActivity(
            action: 'Removed a study type',
            description: StudyType::findOrFail($studyTypeId)->description,
            id_project: $projectId
        );

        $progress = app(PlanningProgressController::class)->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Study type removed from the project')
            ->with('progress', $progress);
    }

    /**
     * Log activity for the specified study type.
     *
     * @param  string  $action
     * @param  string  $description
     * @param  string  $id_project
     * @return void
     */
    private function logActivity(string $action, string $description, string $id_project)
    {
        $activity = $action . " " . $description;
        ActivityLogHelper::insertActivityLog(
            activity: $activity,
            id_module: 1,
            id_project: $id_project,
            id_user: Auth::id()
        );
    }
}

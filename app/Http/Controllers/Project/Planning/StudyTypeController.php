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

namespace App\Http\Controllers\Project\Planning;

use App\Http\Requests\StudyTypeUpdateRequest;
use App\Models\StudyType;
use App\Models\ProjectStudyType;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class StudyTypeController extends Controller
{
    /**
     * Add a study type to the project.
     *
     * @param  StudyTypeUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudyTypeUpdateRequest $request)
    {
        $projectStudyType = ProjectStudyType::firstOrNew([
            'id_project' => $request->id_project,
            'id_study_type' => $request->id_study_type,
        ]);

        if ($projectStudyType->exists) {
            return back()->withErrors([
                'duplicate' => 'The provided study type already exists in this project.',
            ]);
        }

        $projectStudyType->save();

        $studyType = StudyType::findOrFail($request->id_study_type);
        $id_project = $request->id_project;

        $this->logActivity('Added the study type', $studyType->description, $id_project);

        return redirect()
            ->back()
            ->with('success', 'Study type added to the project');
    }

    /**
     * Remove the specified study type from the project.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $projectStudyType = ProjectStudyType::where('id_study_type', $id)->firstOrFail();
        $studyType = StudyType::findOrFail($projectStudyType->id_study_type);
        $id_project = $projectStudyType->id_project;

        $projectStudyType->delete();

        $this->logActivity('Deleted the study type', $studyType->description, $id_project);

        return redirect()
            ->back()
            ->with('success', 'Study type removed from the project');
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
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
    }
}

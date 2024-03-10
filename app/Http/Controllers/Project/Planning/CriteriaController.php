<?php

namespace App\Http\Controllers\Project\Planning;

use App\Models\Criteria;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Project;

class CriteriaController extends Controller
{

    /**
     * Store a newly created Criteria.
     *
     * @param Request $request
     * @param string $projectId
     * @return RedirectResponse
     */
    public function store(Request $request, string $projectId): RedirectResponse
    {
        // Check if the request has a valid project ID
        if ($request->id_project != $projectId) {
            return redirect()
                ->back()
                ->with('error', 'Project not found');
        }

        $project = Project::findOrFail($projectId);

        // Check if another criteria with the same ID already exists in the same project
        if ($project->criterias->contains('id', $request->id)) {
            return redirect()
                ->back()
                ->withErrors([
                    'duplicate' => 'The provided ID already exists in this project.',
                ]);
        }

        $criterion = Criteria::create([
            'id_project' => $request->id_project,
            'id' => $request->id,
            'description' => $request->description,
            'type' => $request->type,
            'pre_selected' => $request->pre_selected,
        ]);

        $activity = "Added the " . $request->type . " criteria " . $criterion->id;
        ActivityLogHelper::insertActivityLog($activity, 1, $projectId, Auth::user()->id);

        return redirect()
            ->back()
            ->with('success', 'Criteria added successfully');
    }


    /**
     * Update an existing Criteria of the project.
     *
     * @param Request $request
     * @param string $projectId
     * @param Criteria $criterion
     * @return RedirectResponse
     */
    public function update(Request $request, string $projectId, Criteria $criterion): RedirectResponse
    {

        $existingCriteria = Criteria::where([
            'id_project' => $request->id_project,
            'id' => $request->id,
        ])->first();

        if ($existingCriteria) {
            return back()->withErrors([
                'duplicate' => 'The provided ID already exists in this project.',
            ]);
        }

        $criterion->update($request->all());

        $this->logActivity('Edited the ' . $criterion->type . ' criteria', $criterion->description, $projectId);

        return redirect()
            ->back()
            ->with('success', 'Criteria updated successfully');
    }

    /**
     * Remove the specified Criteria from the project.
     *
     * @param string $projectId
     * @param Criteria $criterion
     * @return RedirectResponse
     */
    public function destroy(string $projectId, Criteria $criterion): RedirectResponse
    {

        if ($criterion->id_project != $projectId) {
            return redirect()
                ->back()
                ->with('error', 'Criteria not found');
        }


        $activity = "Deleted" . $criterion->type .  "criteria " . $criterion->id;

        $criterion->delete();

        /* ActivityLogHelper::insertActivityLog($activity, 1, $projectId, Auth::user()->id); */
        $this->logActivity('Deleted the ' . $criterion->type . ' criteria', $criterion->description, $projectId);

        return redirect()
            ->back()
            ->with('success', 'Criteria deleted successfully');
    }

    /**
     * Change the pre-selected value of a criteria.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function change_preselected(Request $request, string $id): RedirectResponse
    {
        $this->validate($request, [
            'pre_selected' => 'required|int',
        ]);

        $criterion = Criteria::findOrFail($id);

        $criterion->update($request->all());

        $projectId = $criterion->id_project;

        return redirect()
            ->back()
            ->with('success', 'Pre-selected value updated successfully');
    }

    /**
     * Log activity for the specified domain.
     *
     * @param  string  $action
     * @param  string  $description
     * @param  string  $projectId
     * @return void
     */
    private function logActivity(string $action, string $description, string $projectId): void
    {
        $activity = $action . " " . $description;
        ActivityLogHelper::insertActivityLog($activity, 1, $projectId, Auth::user()->id);
    }
}

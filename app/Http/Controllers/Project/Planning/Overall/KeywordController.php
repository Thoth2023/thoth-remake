<?php

/**
 * File: KeywordController.php
 * Author: Auri Gabriel
 *
 * Description: This is a controller for the project keywords.
 *              It was created as a result of refactoring from the older controller
 *              PlanningOverallInformationController.php, which had too many responsibilities,
 *              was getting too long and hard to maintain.
 *
 * Date: 2024-03-09
 *
 * @see Keyword, Project
 */

namespace App\Http\Controllers\Project\Planning\Overall;

use App\Http\Controllers\Controller;
use App\Http\Requests\KeywordUpdateRequest;
use App\Models\Keyword;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class KeywordController extends Controller
{
    /**
     * Store a newly created keyword.
     *
     * @param  KeywordUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(KeywordUpdateRequest $request): RedirectResponse
    {
        $keyword = Keyword::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);

        $this->logActivity(
            action: 'Added a keyword',
            description: $keyword->description,
            id_project: $request->id_project
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Keyword added successfully');
    }

    /**
     * Update an existing keyword.
     *
     * @param  KeywordUpdateRequest  $request
     * @param  string  $projectId
     * @param  Keyword  $keyword
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(KeywordUpdateRequest $request, string $projectId, Keyword $keyword): RedirectResponse
    {
        if ($keyword->id_project != $projectId) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'overall-info')
                ->with('error', 'Keyword not found');
        }

        $request->validate([
            'description' => 'required|string',
        ]);

        $description_old = $keyword->description;

        $keyword->update([
            'description' => $request->input('description'),
        ]);

        $this->logActivity(
            action: 'Updated the keyword',
            description: $description_old . ' to ' . $keyword->description,
            id_project: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Keyword updated successfully');
    }

    /**
     * Remove the specified keyword from the project.
     *
     * @param  string  $projectId
     * @param  Keyword  $keyword
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $projectId, Keyword $keyword): RedirectResponse
    {
        if ($keyword->id_project != $projectId) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'overall-info')
                ->with('error', 'Keyword not found');
        }

        $keyword->delete();

        $this->logActivity(
            action: 'Deleted the keyword',
            description: $keyword->description,
            id_project: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Keyword deleted successfully');
    }

    /**
     * Log activity for the specified keyword.
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

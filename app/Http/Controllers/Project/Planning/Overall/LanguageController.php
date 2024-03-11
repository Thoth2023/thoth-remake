<?php

/**
 * File: LanguageController.php
 * Author: Auri Gabriel
 *
 * Description: This is the controller for the project languages.
 *              It was created as a result of refactoring from the older controller
 *              PlanningOverallInformationController.php, which had too many responsibilities,
 *              was getting too long and hard to maintain.
 *
 * Date: 2024-03-09
 *
 * @see Language, Project, ProjectLanguage
 */

namespace App\Http\Controllers\Project\Planning\Overall;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageUpdateRequest;
use App\Models\Language;
use App\Models\Project;
use App\Models\ProjectLanguage;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Add a language to the project.
     *
     * @param  LanguageUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LanguageUpdateRequest $request): RedirectResponse
    {
        $projectLanguage = ProjectLanguage::firstOrNew([
            'id_project' => $request->id_project,
            'id_language' => $request->id_language,
        ]);

        if ($projectLanguage->exists) {
            return back()
                ->with('activePlanningTab', 'overall-info')
                ->withErrors([
                    'duplicate' => 'The provided language already exists in this project.',
                ]);
        }

        $projectLanguage->save();

        $language = Language::findOrFail($request->id_language);
        $id_project = $request->id_project;

        $this->logActivity(
            action: 'Added a language',
            description: $language->description,
            id_project: $id_project
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Language added to the project');
    }

    /**
     * Remove the specified language from the project.
     *
     * @param string $projectId
     * @param string $languageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $projectId, string $languageId): RedirectResponse
    {
        $projectLanguage = ProjectLanguage::where('id_project', $projectId)
            ->where('id_language', $languageId)
            ->first();

        $projectLanguage->delete();

        $this->logActivity(
            action: 'Removed the language',
            description: Language::findOrFail($languageId)->description,
            id_project: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Language removed from the project');
    }

    /**
     * Log activity for the specified language.
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

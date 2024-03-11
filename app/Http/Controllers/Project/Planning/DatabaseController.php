<?php

/**
 * File: DatabaseController.php
 * Author: gpmatheus,
 *         Auri Gabriel
 *
 * Description: This is the controller class for the Database model.
 *              It was created as a result of refactoring from the older controller
 *              DataBasesController.php, which dind't follow Laravel best practices.
 *
 *
 * Date: 2024-03-09
 *
 * @see Database, Project
 */

namespace App\Http\Controllers\Project\Planning;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Database;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ProjectDatabase;
use Illuminate\Http\RedirectResponse;

class DatabaseController extends Controller
{
    /**
     * Add a database to the project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $projectId
     * @param Database $database
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addDatabase(Request $request, string $projectId): RedirectResponse
    {
        $project = Project::findOrFail($projectId);

        $databaseId = $request->databaseId;

        if ($project->databases->contains($databaseId)) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'databases')
                ->with('error', 'Database already added to the project');
        }

        $database = Database::findOrFail($databaseId);

        if ($database->state !== 'approved') {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'databases')
                ->with('error', 'Database not approved yet');
        }

        $project->databases()->attach($databaseId);

        $this->logActivity(
            action: 'Added the database',
            description: $database->name,
            id_project: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'data-bases')
            ->with('success', 'Database added to the project');
    }

    /**
     * Remove the specified database from the project.
     *
     * @param  string $projectId
     * @param  string $databaseId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeDatabase(string $projectId, string $databaseId): RedirectResponse
    {
        $projectDatabase = ProjectDatabase::where('id_project', $projectId)
            ->where('id_database', $databaseId)
            ->first();

        if (!$projectDatabase) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'data-bases')
                ->with('error', 'Database not found in the project');
        }

        $projectDatabase->delete();

        $this->logActivity(
            action: 'Removed the database',
            description: Database::findOrFail($databaseId)->name,
            id_project: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'data-bases')
            ->with('success', 'Database removed from the project');
    }

    /**
     * Store a newly created database in the project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $projectId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, string $projectId)
    {
        $this->validate($request, [
            'db_name' => 'required|string',
            'db_link' => 'required|string',
        ]);

        $database = Database::create([
            'name' => $request->db_name,
            'link' => $request->db_link,
        ]);

        $this->logActivity(
            action: 'Suggested the database',
            description: $database->name,
            id_project: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'data-bases')
            ->with('success', 'Database Suggested successfully');
    }

    /**
     * Log activity for the specified database.
     *
     * @param  string  $action
     * @param  string  $description
     * @param  string  $id_project
     * @return void
     */

    private function logActivity(string $action, string $description, string $id_project): void
    {
        $activity = $action . " " . $description;
        ActivityLogHelper::insertActivityLog(
            activity: $activity,
            id_module: 1,
            id_project: $id_project,
            id_user: Auth::user()->id,
        );
    }
}

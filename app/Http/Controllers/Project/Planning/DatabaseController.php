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
use Illuminate\Http\RedirectResponse;

class DatabaseController extends Controller
{
    /**
     * Display a listing of databases for a specific project.
     *
     * @param  int  $projectId
     * @return \Illuminate\View\View
     */
    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);
        $databases = Database::all();

        return view('project.planning.databases.index', compact('project', 'databases'));
    }

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

        if ($project->databases->contains($databaseId))
        {
            return redirect()
                ->back()
                ->with('error', 'Database already added to the project');
        }

        $database = Database::findOrFail($databaseId);

        $project->databases()->attach($databaseId);

        $this->logActivity('Added the database', $database->name, $projectId);

        return redirect()
            ->back()
            ->with('success', 'Database added to the project');
    }

    /**
     * Remove the specified database from the project.
     *
     * @param Request $request
     * @param  string $projectId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeDatabase(Request $request, string $projectId)
    {
        $project = Project::findOrFail($projectId);

        $databaseId = $request->query('databaseId');

        if (!$project->databases->contains($databaseId))
        {
            return redirect()
                ->back()
                ->with('error', 'Database not found in the project');
        }

        $project->databases()->detach($databaseId);

        $database = Database::findOrFail($databaseId);

        $this->logActivity('Removed the database', $database->name, $projectId);

        return redirect()
            ->back()
            ->with('success', 'Database removed from the project');
    }

    /**
     * Store a newly created database in the project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $projectId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $projectId)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'link' => 'required|string',
        ]);

        $database = Database::create([
            'name' => $request->name,
            'link' => $request->link,
        ]);

        $project = Project::findOrFail($projectId);
        $project->databases()->attach($database->id);

        $this->logActivity('Added the database', $database->name, $projectId);

        return redirect()->route('projects.databases.index', $projectId);
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
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
    }
}

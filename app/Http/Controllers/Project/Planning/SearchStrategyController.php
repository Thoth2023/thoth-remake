<?php
/**
 * File: SearchStrategyController.php
 * Author: Auri Gabriel
 *
 * Description: This is the controller class for the SearchStrategy
 *
 * Date: 2023-06-02
 *
 * @see SearchStrategy, Project
 */

namespace App\Http\Controllers\Project\Planning;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class SearchStrategyController extends Controller
{
    /**
     * Update the search strategy of the project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $projectId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId): RedirectResponse
    {
        $request->validate([
            'search_strategy' => 'required',
        ]);

        $project = Project::findOrFail($projectId);
        $project->searchStrategy()
                ->updateOrCreate([], ['description' => $request->search_strategy]);

        $this->logActivity('Updated the search strategy', $project->searchStrategy->description, $projectId);

        return redirect()
            ->back()
            ->with('success', 'Search Strategy updated successfully');
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

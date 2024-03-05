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

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;

class SearchStrategyController extends Controller
{
    /**
     * Show the form for editing the search strategy.
     *
     * @param  int  $projectId
     * @return \Illuminate\Http\Response
     */
    public function edit($projectId)
    {
        $project = Project::findOrFail($projectId);

        return view('project.planning.search-strategy', compact('project'));
    }

    /**
     * Update the search strategy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $projectId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId)
    {
        $request->validate([
            'search_strategy' => 'required',
        ]);

        $project = Project::findOrFail($projectId);
        $project->searchStrategy()
                ->updateOrCreate([], ['description' => $request->search_strategy]);

        $activity = "Edited search strategy";
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);

        return redirect()->back() ->with('message', 'Search strategy updated successfully') ->with('message_type', 'success');
    }
}


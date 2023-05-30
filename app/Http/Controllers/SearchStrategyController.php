<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchStrategy;
use App\Models\Project;

class SearchStrategyController extends Controller
{
    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);
        $searchStrategy = $project->searchStrategy;
        return view('planning.search_strategy', compact('project', 'searchStrategy'));
    }

    public function update(Request $request, $projectId)
    {
        $validatedData = $request->validate([
            'planning.search_strategy' => 'required',
        ]);

        $project = Project::findOrFail($projectId);
        $searchStrategy = $project->searchStrategy;

        if ($searchStrategy) {
            $searchStrategy->update([
                'description' => $validatedData['search_strategy'],
            ]);
        } else {
            SearchStrategy::create([
                'description' => $validatedData['search_strategy'],
                'project_id' => $project->id_project,
            ]);
        }

        return redirect()->back()->with('success', 'Search strategy updated successfully.');
    }
}

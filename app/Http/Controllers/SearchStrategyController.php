<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

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

        return view('planning.search_strategy', compact('project'));
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

        return redirect()->back()
                         ->with('message', 'Search strategy updated successfully')
                         ->with('message_type', 'success');
    }
}


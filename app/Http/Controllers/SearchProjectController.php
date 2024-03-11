<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class SearchProjectController extends Controller
{
    public function searchByTitleOrCreated(Request $request)
    {
        $searchProject = $request->searchProject;
        $projects = Project::where('title', 'like', '%' . $searchProject . '%')
                            ->orWhere('created_by', 'like', '%' . $searchProject . '%')
                            ->get();

        return view('projects.search-project', compact('projects', 'searchProject'));
    }
}

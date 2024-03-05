<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

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

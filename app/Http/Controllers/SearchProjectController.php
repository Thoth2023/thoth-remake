<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class SearchProjectController extends Controller
{
    public function searchByTitleOrCreated(Request $request)
    {
        $user = Auth::user();
        $searchProject = $request->searchProject;

        $projects = Project::whereHas('users', function($query) use ($user) {
                                $query->where('id_user', $user->id);
                            })
                            ->where(function($query) use ($searchProject) {
                                $query->where('title', 'like', '%' . $searchProject . '%')
                                    ->orWhere('created_by', 'like', '%' . $searchProject . '%');
                            })
                            ->get();

        return view('projects.search-project', compact('projects', 'searchProject'));
    }
}

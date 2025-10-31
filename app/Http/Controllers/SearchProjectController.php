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

        $projects = Project::where(function($query) use ($user) {
            // Projetos que o usuário participa
            $query->whereHas('users', function($q) use ($user) {
                $q->where('id_user', $user->id);
            })
                // OU projetos públicos
                ->orWhere('is_public', 1);
        })
            ->where(function($query) use ($searchProject) {
                $query->where('title', 'like', '%' . $searchProject . '%')
                    ->orWhere('created_by', 'like', '%' . $searchProject . '%');
            })
            ->get();

        return view('projects.search-project', compact('projects', 'searchProject'));
    }

}

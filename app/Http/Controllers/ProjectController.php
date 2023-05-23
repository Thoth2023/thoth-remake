<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $id = Auth::user()->id;
        $projects = Project::where('id_user', $id)->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' =>'required|string|max:255',
            'description' =>'required|string',
            'objectives' =>'required|string'
        ]);

        $id_user = Auth::user()->id;
        Project::create([
            'id_user' => $id_user,
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
            //'copy_planning'
        ]);
        return redirect('/projects');
    }

    /**
     * Display the specified project.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(string $idProject)
    {
        $project = Project::findOrFail($idProject);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return redirect('/projects');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(string $id)
    {
         $project = Project::findOrFail($id);
         $project->delete();
         return redirect('/projects');
    }

    public function add_member(string $idProject) 
    {
        $project = Project::findOrFail($idProject); 
        return view('projects.add_member', compact('project')); //compact() passa o projeto para a view
    }

    public function add_member_update(Request $request, string $idProject)
    {
        $email_member = $request->get('email_member');
        $user_id = $this->findIdByEmail($email_member);
        $level_member = $request->get('level_member');

        $data = User::where('email', $email_member)->first(); // ->get();
        //$user_id = User::findOrFail($data->id); // pega o id do "novo" membro
        
        $table_data = [ // tabela intermediaria "members" 
            'id_user' => $user_id,
            'id_project' => $idProject,
            'level' => $level_member, // $request->input(1)
        ];
    
        DB::table('members')->insert($table_data);

        $project = Project::findOrFail($idProject);
        $project->update($request->all());
        return redirect('/projects');
    }

    public function findIdByEmail($email)
    {
        try {
            $user = User::where('email', $email)->firstOrFail();
            $userId = $user->id;

            return $userId;
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }

}

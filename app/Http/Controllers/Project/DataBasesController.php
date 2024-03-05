<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\DataBase;
use App\Models\Project;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataBasesController extends Controller
{
    public function index($id)
    {
        $project = Project::find($id);
        $databases = DataBase::all();
        return view('project.planning.databases', compact('project'), compact('databases'));
    }

    public function add_database(Request $request, string $id_project)
    {
        $project = Project::find($id_project);
        if (!$project->databases->contains('id_database', $request->database)) {
            $project->databases()->attach($request->database);
        }
        return redirect('/planning/' . $id_project);
    }

    public function remove_database(string $id_project, string $id_database)
    {
        $project = Project::find($id_project);
        $database = DataBase::findOrFail($id_database);
        $activity = "Deleted the data base " . $database->name;

        $project->databases()->detach($id_database);

        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);

        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);

        return redirect('/planning/' . $id_project);
    }

    public function create_database(Request $request, string $id_project)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'link' => 'required|string'
        ]);
        $database = DataBase::create([
            'name' => $request->name,
            'link' => $request->link
        ]);
        $project = Project::findOrFail($id_project);
        $project->databases()->attach($database->id_database);

        $activity = "Added the data base " . $database->name;
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);


        return redirect('/planning/' . $id_project);
    }
}

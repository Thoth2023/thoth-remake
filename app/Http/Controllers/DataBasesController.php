<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\DataBase;

class DataBasesController extends Controller
{
	public function index($id) {
		$project = Project::find($id);
		$databases = DataBase::all();
        return view('planning.databases', compact('project'), compact('databases'));
	}

	public function add_database(Request $request, string $id_project) {
		$project = Project::find($id_project);
		if (!$project->databases->contains('id_database', $request->database)) {
			$project->databases()->attach($request->database);
		}
		return redirect('/projects/'.$id_project.'/planning/data-bases');
	}

	public function remove_database(string $id_project, string $id_database) {
		$project = Project::find($id_project);
		$project->databases()->detach($id_database);

		return redirect('/projects/'.$id_project.'/planning/data-bases');
	}

	public function create_database(Request $request, string $id_project) {
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

		return redirect('/projects/'.$id_project.'/planning/data-bases');
	}
}

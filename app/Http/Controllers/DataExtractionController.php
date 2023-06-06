<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\QuestionExtraction;
use App\Models\TypesQuestion;
use App\Models\OptionsExtraction;

class DataExtractionController extends Controller
{
	public function index($id) {
		$project = Project::find($id);
		$types = TypesQuestion::all();

        return view('planning.data_extraction', compact('project', 'types'));
	}

	public function add_extraction(Request $request, string $id_project) {
		$this->validate($request, [
			'id' => 'required|string',
			'description' => 'required|string',
		]);
		$question = QuestionExtraction::create([
			'id' => $request->id,
			'description' => $request->description,
			'id_project' => $id_project,
			'type' => $request->type
		]);
		return redirect('/projects/'.$id_project.'/planning/data-extraction');
	}

	public function add_option(Request $request, string $id_project) {
		$this->validate($request, [
			'questionId' => 'required|string',
			'option' => 'required|string'
		]);
		$option = OptionsExtraction::create([
			'description' => $request->option,
			'id_de' => $request->questionId,
		]);
		return redirect('/projects/'.$id_project.'/planning/data-extraction');
	}

	public function delete_question(string $id_project, string $id_question) {
		$question = QuestionExtraction::findOrFail($id_question);
		$question->options()->delete();
		$question->delete();

		return redirect('/projects/'.$id_project.'/planning/data-extraction');
	}

	public function delete_option(string $id_project, string $id_option) {
		$option = OptionsExtraction::findOrFail($id_option);
		$option->delete();

		return redirect('/projects/'.$id_project.'/planning/data-extraction');
	}

	public function edit_question(Request $request, string $id_project, string $id_question) {
		$question = QuestionExtraction::findOrFail($id_question);
		$question->update([
			'id' => $request->id,
			'description' => $request->description,
			'type' => $request->type
		]);
		$question->save();
		return redirect('/projects/'.$id_project.'/planning/data-extraction');
	}
}

<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\OptionsExtraction;
use App\Models\Project;
use App\Models\QuestionExtraction;
use App\Models\TypesQuestion;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataExtractionController extends Controller
{
    public function index($id)
    {
        $project = Project::find($id);
        $types = TypesQuestion::all();

        return view('project.planning.data_extraction', compact('project', 'types'));
    }

    public function add_extraction(Request $request, string $id_project)
    {
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

        $activity = "Added question extraction " . $question->id;
        ActivityLogHelper::insertActivityLog($activity, 1, $question->id_project, Auth::user()->id);

        return redirect('/projects/' . $id_project . '/planning/data-extraction');
    }

    public function add_option(Request $request, string $id_project)
    {
        $this->validate($request, [
            'option' => 'required|string'
        ]);
        $option = OptionsExtraction::create([
            'description' => $request->option,
            'id_de' => $request->questionId,
        ]);
        $activity = "Added option to question extraction " . QuestionExtraction::findOrFail($option->id_de)->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
        return redirect('/projects/' . $id_project . '/planning/data-extraction');
    }

    public function delete_question(string $id_project, string $id_question)
    {
        $question = QuestionExtraction::findOrFail($id_question);
        $activity = "Deleted question extraction " . $question->id;

        $question->options()->delete();
        $question->delete();

        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect('/projects/' . $id_project . '/planning/data-extraction');
    }

    public function delete_option(string $id_project, string $id_option)
    {
        $option = OptionsExtraction::findOrFail($id_option);
        $activity = "Deleted option " . $option->description . " to question extraction " . QuestionExtraction::findOrFail($option->id_de)->description;

        $option->delete();

        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect('/projects/' . $id_project . '/planning/data-extraction');
    }

    public function edit_question(Request $request, string $id_project, string $id_question)
    {
        $this->validate($request, [
            'id' => 'required|string',
            'description' => 'required|string',
        ]);
        $question = QuestionExtraction::findOrFail($id_question);
        $type = TypesQuestion::findOrFail($request->type);
        if ($type->type == 'Text') {
            $question->options()->delete();
        }
        $question->update([
            'id' => $request->id,
            'description' => $request->description,
            'type' => $request->type
        ]);
        $question->save();

        $activity = "Edited question extraction " . $question->id;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect('/projects/' . $id_project . '/planning/data-extraction');
    }

    public function edit_option(Request $request, string $id_project, string $id_option)
    {
        $this->validate($request, [
            'option' => 'required|string'
        ]);
        $option = OptionsExtraction::findOrFail($id_option);
        $option->update([
            'description' => $request->option
        ]);
        $option->save();
        $activity = "Edited option to question extraction " . QuestionExtraction::findOrFail($option->id_de)->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect('/projects/' . $id_project . '/planning/data-extraction');
    }
}

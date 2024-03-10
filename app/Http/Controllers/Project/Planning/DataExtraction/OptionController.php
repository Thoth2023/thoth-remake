<?php
/**
 * File: OptionController.php
 * Author: Auri Gabriel
 *
 * Description: The controller for the data extraction question options.
 *
 * Date: 2024-03-10
 *
 * @see Option, Question
 */

namespace App\Http\Controllers\Project\Planning\DataExtraction;

use App\Http\Requests\Project\Planning\DataExtraction\Option\StoreOptionRequest;
use App\Http\Requests\Project\Planning\DataExtraction\Option\UpdateOptionRequest;
use App\Models\Project\Planning\DataExtraction\Option;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Project\Planning\DataExtraction\Question;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOptionRequest  $request
     * @param  string  $projectId
     * @return RedirectResponse
     */
    public function store(string $projectId, StoreOptionRequest $request): RedirectResponse
    {
        dd($request->all());
        /* if (!$request) { */
        /*     return redirect() */
        /*         ->back() */
        /*         ->with('error', 'Question not found'); */
        /* } */
        /* $question = Question::find($request->questionId); */

        /* if (!$question) { */
        /*     return redirect() */
        /*         ->back() */
        /*         ->with('error', 'Question not found'); */
        /* } */

        /* $option = Option::create([ */
        /*     'id_de' => $question->id_de, */
        /*     'description' => $request->option, */
        /* ]); */


        /* $this->logActivity('Added a option', $option->description, $option->id, $projectId); */

        /* return redirect() */
        /*     ->back() */
        /*     ->with('success', 'Option added successfully'); */
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionRequest $request, Option $option)
    {
        dd([
            $request,
            $option,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Option $option
     * @return RedirectResponse
     */
    public function destroy(string $projectId, Option $option): RedirectResponse
    {
        $option->delete();

        $this->logActivity('Deleted a option', $option->description, $option->id, $projectId);

        return redirect()->back()->with('success', 'Question deleted successfully');
    }

    /**
     * Log activity for the specified question.
     *
     * @param  string  $action
     * @param  string  $description
     * @param  int  $questionId
     * @return void
     */
    private function logActivity(string $action, string $description, string $questionId, string $projectId): void
    {
        $activity = $action . " " . $description;
        ActivityLogHelper::insertActivityLog(
            activity: $activity,
            id_module: 1,
            id_project: $projectId,
            id_user: Auth::user()->id
        );
    }
}

<?php

/**
 * File: QuestionController.php
 * Author: Auri Gabriel
 *
 * Description: The controller for the data extracton questions.
 *
 * Date: 2024-03-10
 *
 * @see Question
 */

namespace App\Http\Controllers\Project\Planning\DataExtraction;

use App\Http\Requests\Project\Planning\DataExtraction\Question\StoreQuestionRequest;
use App\Http\Requests\Project\Planning\DataExtraction\Question\UpdateQuestionRequest;
use App\Models\Project\Planning\DataExtraction\Question;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreQuestionRequest  $request
     * @param  string  $projectId
     * @return RedirectResponse
     */
    public function store(StoreQuestionRequest $request, string $projectId): RedirectResponse
    {

        $question = Question::create([
            'id' => $request->id,
            'id_project' => $projectId,
            'description' => $request->description,
            'type' => $request->type,
        ]);

        $this->logActivity('Added a question', $question->description, $question->id, $projectId);

        return redirect()->back()->with('success', 'Question added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateQuestionRequest  $request
     * @param  Question  $question
     * @return RedirectResponse
     */
    public function update(UpdateQuestionRequest $request, Question $question): RedirectResponse
    {
        dd([$request, $question]);
        $description_old = $question->description;

        $question->update([
            'id' => $request->id,
            'description' => $request->description,
            'type' => $request->type,
        ]);

        $this->logActivity('Edited a question', $description_old . " to " . $question->description, $question->id, $question->id_project);

        return redirect()->back()->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question  $question
     * @return RedirectResponse
     */
    public function destroy(string $projectId, Question $question): RedirectResponse
    {
        $question->delete();

        $this->logActivity('Deleted a question', $question->description, $question->id, $projectId);

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

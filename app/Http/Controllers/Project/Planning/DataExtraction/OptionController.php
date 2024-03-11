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
    public function store(StoreOptionRequest $request, string $projectId): RedirectResponse
    {
        if (!$request) {
            return redirect()
                ->back()
                ->with('error', 'Question not found');
        }
        $question = Question::find($request->questionId);

        if (!$question) {
            return redirect()
                ->back()
                ->with('error', 'Question not found');
        }

        $option = Option::create([
            'id_de' => $question->id_de,
            'description' => $request->option,
        ]);


        $this->logActivity(
            action: 'Added a option',
            description: $option->description,
            optionId: $option->id_option,
            projectId: $projectId
        );

        return redirect()
            ->back()
            ->with('success', 'Option added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOptionRequest  $request
     * @param string projectId
     * @param  Option  $option
     * @return RedirectResponse
     */
    public function update(UpdateOptionRequest $request, string $projectId, Option $option): RedirectResponse
    {
        $description_old = $option->description;

        $option->update([
            'description' => $request->option,
        ]);

        $this->logActivity(
            action: 'Edited a option',
            description: $description_old . " to " . $option->description,
            optionId: $option->id_option,
            projectId: $projectId
        );

        return redirect()
            ->back()
            ->with('success', 'Option updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Option $option
     * @return RedirectResponse
     */
    public function destroy(string $projectId, Option $option): RedirectResponse
    {

        $this->logActivity(
            action: 'Deleted a option',
            description: $option->description,
            optionId: $option->id_option,
            projectId: $projectId
        );

        $option->delete();

        return redirect()
            ->back()
            ->with('success', 'Question deleted successfully');
    }

    /**
     * Log activity for the specified question.
     *
     * @param  string  $action
     * @param  string  $description
     * @param  int  $optionId
     * @return void
     */
    private function logActivity(string $action, string $description, string $optionId, string $projectId): void
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

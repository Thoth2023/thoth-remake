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

use App\Http\Controllers\Project\Planning\PlanningProgressController;
use App\Http\Requests\Project\Planning\DataExtraction\Option\StoreOptionRequest;
use App\Http\Requests\Project\Planning\DataExtraction\Option\UpdateOptionRequest;
use App\Models\Project\Planning\DataExtraction\Option;
use App\Utils\ActivityLogHelper as Log;
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
                ->with('activePlanningTab', 'data-extraction')
                ->with('error', 'Question not found');
        }
        $question = Question::find($request->questionId);

        if (!$question) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'data-extraction')
                ->with('error', 'Question not found');
        }

        $option = Option::create([
            'id_de' => $question->id_de,
            'description' => $request->option,
        ]);

        // Registra a edição no log do sistema
        Log::logActivity(
            action: 'Added a option',
            description: $option->description,
            module: 1,
            projectId: $projectId
        );


        $progress = app(PlanningProgressController::class)->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'data-extraction')
            ->with('progress', $progress)
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

        // Registra a edição no log do sistema
        Log::logActivity(
            action: 'Edited a option',
            description: $description_old . " to " . $option->description,
            module: 1,
            projectId: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'data-extraction')
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

        // Registra a exclusão no log do sistema
        Log::logActivity(
            action: 'Deleted a option',
            description: $option->description,
            module: 1,
            projectId: $projectId
        );

        $option->delete();
        $progress = app(PlanningProgressController::class)->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'data-extraction')
            ->with('progress', $progress)
            ->with('success', 'Option deleted successfully');
    }

}

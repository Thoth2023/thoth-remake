<?php

namespace App\Http\Controllers\Project\Planning\QualityAssessment;

use App\Http\Requests\Project\Planning\QualityAssessment\Question\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Project\Planning\QualityAssessment\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Utils\ActivityLogHelper;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request, string $projectId): RedirectResponse
    {
        $question = Question::create([
            'id_project' => $projectId,
            'id' => $request->id,
            'description' => $request->description,
            'weight' => $request->weight,
        ]);

        $this->logActivity(
            action: 'Added a Quality Assessment Question',
            description: $question->description,
            projectId: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'quality-assessment')
            ->with('success', 'Question added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }

    /**
     * Log activity for the specified QA Question.
     *
     * @param  string  $action
     * @param  string  $description
     * @param  string  $projectId
     * @return void
     */
    private function logActivity(string $action, string $description, string $projectId): void
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

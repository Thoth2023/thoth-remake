<?php

namespace App\Http\Controllers\Project\Planning\QualityAssessment;

use App\Http\Requests\Project\Planning\QualityAssessment\GeneralScore\StoreGeneralScoreRequest;
use App\Http\Requests\Project\Planning\QualityAssessment\GeneralScore\UpdateGeneralScoreRequest;
use App\Models\GeneralScore;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Http\Controllers\Controller;

class GeneralScoreController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralScoreRequest $request, string $projectId): RedirectResponse
    {
        $project = Project::find($projectId);

        // Get all the general scores of the project
        $projectScores = $project->generalScores;

        $newGeneralScore = new GeneralScore([
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'id_project' => $projectId,
        ]);

        if ($this->isScoreValid($newGeneralScore, $projectScores)) {
            $newGeneralScore->save();

            return redirect()
                ->back()
                ->with('activePlanningTab', 'quality-assessment')
                ->with('success', 'General score added successfully');
        } else {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'quality-assessment')
                ->with('error', 'The score range overlaps with another score');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneralScoreRequest $request, string $projectId, GeneralScore $generalScore): RedirectResponse
    {
        $project = Project::find($projectId);

        // Get all the general scores of the project
        $projectScores = $project->generalScores;

        $newGeneralScore = new GeneralScore([
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'id_project' => $projectId,
        ]);

        if (!$this->isScoreValid($newGeneralScore, $projectScores)) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'quality-assessment')
                ->with('error', 'The score range overlaps with another score');
        }

        $generalScore->update([
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
        ]);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'quality-assessment')
            ->with('success', 'General score updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $projectId, GeneralScore $generalScore): RedirectResponse
    {
        $generalScore->delete();
        return redirect()
            ->back()
            ->with('activePlanningTab', 'quality-assessment')
            ->with('success', 'General score deleted successfully');
    }

    /**
     * Validate that the start and end ranges of a Score is valid
     *
     * @param GeneralScore $newGeneralScore
     */
    private function isScoreValid(GeneralScore $newGeneralScore, $projectScores): bool
    {
        // Check if the start range is before the end range of the new GeneralScore
        if ($newGeneralScore->start >= $newGeneralScore->end) {
            return false;
        }

        // Check if the range of the new score is within the interval of another general score.
        foreach ($projectScores as $projectScore) {
            if ($newGeneralScore->start <= $projectScore->end && $newGeneralScore->end >= $projectScore->start) {
                return false;
            }
        }

        return true;
    }
}

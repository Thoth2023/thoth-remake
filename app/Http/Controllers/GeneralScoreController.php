<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\Planning\QualityAssessment\GeneralScore\StoreGeneralScoreRequest;
use App\Http\Requests\Project\Planning\QualityAssessment\GeneralScore\UpdateGeneralScoreRequest;
use App\Models\GeneralScore;
use App\Rules\NoOverlap;
use Illuminate\Http\RedirectResponse;

class GeneralScoreController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralScoreRequest $request, string $projectId): RedirectResponse
    {
        // TODO: Validate that the start and end dates do not overlap with other general scores.
        GeneralScore::create([
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'id_project' => $projectId,
        ]);
        return redirect()
            ->back()
            ->with('activePlanningTab', 'quality-assessment')
            ->with('success', 'General score added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneralScoreRequest $request, string $projectId, GeneralScore $generalScore): RedirectResponse
    {
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
}

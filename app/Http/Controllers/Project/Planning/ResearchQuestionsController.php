<?php

namespace App\Http\Controllers\Project\Planning;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ResearchQuestion;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ResearchQuestionsController extends Controller
{
    /**
     * Store a newly created Research Question
     *
     * @param  ResearchQuestionUpdateRequest  $request
     * @param  string  $projectId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, string $projectId): RedirectResponse
    {
        // Checkt if the request has a valid project ID
        if ($request->id_project != $projectId) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'research-questions')
                ->with('error', 'Project not found');
        }

        $project = Project::findOrFail($projectId);

        // Check if another research question with the same ID already exists
        // in the same project
        if ($project->researchQuestions->contains('id', $request->id)) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'research-questions')
                ->withErrors([
                    'duplicate' => 'The provided ID already exists in this project.',
                ]);
        }

        $researchQuestion = ResearchQuestion::create([
            'id_project' => $request->id_project,
            'id' => $request->id,
            'description' => $request->description,
        ]);

        $this->logActivity(
            action: 'Added a research question',
            description: $researchQuestion->description,
            projectId: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'research-questions')
            ->with('success', 'Research question added successfully');
    }

    /**
     * Update an existing Research Question
     *
     * @param  DomainUpdateRequest  $request
     * @param  string  $projectId
     * @param  ResearchQuestion  $researchQuestion
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $projectId, ResearchQuestion $researchQuestion): RedirectResponse
    {
        if ($researchQuestion->id_project != $projectId) {
            return redirect()
                ->back()
                ->with('activePlanningTab', 'research-questions')
                ->with('error', 'Research question not found');
        }

        $request->validate([
            'description' => 'required|string',
        ]);

        $description_old = $researchQuestion->description;

        $researchQuestion->update([
            'description' => $request->input('description'),
        ]);

        $this->logActivity(
            action: 'Updated the research question',
            description: $description_old . ' to ' . $researchQuestion->description,
            projectId: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'research-questions')
            ->with('success', 'Research question updated successfully');
    }

    /**
     * Remove the specified domain from the project.
     *
     * @param  string $projectId
     * @param  ResearchQuestion $researchQuestion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $projectId, ResearchQuestion $researchQuestion): RedirectResponse
    {
        if ($researchQuestion->id_project != $projectId) {
            return redirect()->back()->with('error', 'Domain not found');
        }

        $researchQuestion->delete();

        $this->logActivity(
            action: 'Deleted the research question',
            description: $researchQuestion->description,
            projectId: $projectId
        );

        return redirect()
            ->back()
            ->with('activePlanningTab', 'research-questions')
            ->with('success', 'Research question deleted successfully');
    }

    /**
     * Log activity for the specified ResearchQuestion.
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

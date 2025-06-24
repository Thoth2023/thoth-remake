<?php
/**
 * File: DomainController.php
 * Author: Auri Gabriel
 *
 * Description: This file handles the operations on the project domains.
 *              It was created as a result of refactoring from the older controller
 *              PlanningOverallInformationController.php, which had too many responsibilities,
 *              was getting too long and hard to maintain.
 *
 * Date: 2024-03-09
 *
 * @see Domain, Project
 */

namespace App\Http\Controllers\Project\Planning\Overall;

use App\Http\Controllers\Controller;
use App\Http\Requests\DomainUpdateRequest;
use App\Models\Domain;
use App\Http\Controllers\Project\Planning\PlanningProgressController;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    private PlanningProgressController $progressCalculator;

    public function __construct(PlanningProgressController $progressCalculator)
    {
        $this->progressCalculator = $progressCalculator;
    }

    /**
     * Store a newly created domain.
     *
     * @param  DomainUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DomainUpdateRequest $request): RedirectResponse
    {
        $domain = Domain::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);

        $this->logActivity(
            action: 'Added a domain',
            description: $domain->description,
            projectId: $request->id_project
        );

        $progress = $this->progressCalculator->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Domain added successfully')
            ->with('progress', $progress);
    }

    /**
     * Update an existing domain.
     *
     * @param  DomainUpdateRequest  $request
     * @param  string  $projectId
     * @param  Domain  $domain
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DomainUpdateRequest $request, string $projectId, Domain $domain): RedirectResponse
    {
        if ($domain->id_project != $projectId) {
            return redirect()
                ->back()
                ->with('error', 'Domain not found');
        }

        $request->validate([
            'description' => 'required|string',
        ]);

        $description_old = $domain->description;

        $domain->update([
            'description' => $request->input('description'),
        ]);

        $this->logActivity(
            action: 'Updated the domain',
            description: $description_old,
            projectId: $projectId
        );

        $progress = $this->progressCalculator->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Domain updated successfully')
            ->with('progress', $progress);
    }

    /**
     * Remove the specified domain from the project.
     *
     * @param  string $projectId
     * @param  Domain $domain
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $projectId, Domain $domain)
    {
        if ($domain->id_project != $projectId) {
            return redirect()->back()->with('error', 'Domain not found');
        }

        $domain->delete();

        $this->logActivity(
            action: 'Deleted the domain',
            description: $domain->description,
            projectId: $projectId
        );

        $progress = $this->progressCalculator->calculate($projectId);

        return redirect()
            ->back()
            ->with('activePlanningTab', 'overall-info')
            ->with('success', 'Domain deleted successfully')
            ->with('progress', $progress);
    }

    /**
     * Log activity for the specified domain.
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

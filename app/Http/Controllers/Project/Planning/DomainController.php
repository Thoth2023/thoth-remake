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

namespace App\Http\Controllers\Project\Planning;

use App\Http\Requests\DomainUpdateRequest;
use App\Models\Domain;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class DomainController extends Controller
{
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

        $this->logActivity('Added the domain', $domain->description, $request->id_project);

        return redirect()->back()->with('success', 'Domain added successfully');
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
        if ($domain->id_project != $projectId)
        {
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

        $this->logActivity('Edited the domain', $description_old . " to " . $domain->description, $domain->id_project);

        return redirect()
            ->back()
            ->with('success', 'Domain updated successfully');
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
        if ($domain->id_project != $projectId)
        {
            return redirect()->back()->with('error', 'Domain not found');
        }

        $domain->delete();

        $this->logActivity('Deleted the domain', $domain->description, $projectId);

        return redirect()
            ->route('project.planning.index', ['projectId' => $projectId])
            ->with('success', 'Domain deleted successfully');
    }

    /**
     * Log activity for the specified domain.
     *
     * @param  string  $action
     * @param  string  $description
     * @param  string  $id_project
     * @return void
     */
    private function logActivity(string $action, string $description, string $id_project): void
    {
        $activity = $action . " " . $description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
    }
}

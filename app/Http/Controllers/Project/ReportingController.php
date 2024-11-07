<?php
/**
 * File: ReportingController.php
 * Author: Auri Gabriel
 *
 * Description: This is the controller class for the Reporting
 *
 * Date: 2023-11-12
 *
 * @see Reporting, Project
 */

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

class ReportingController extends Controller
{
    public function index(string $id_project): View|RedirectResponse
    {
        $project = Project::findOrFail($id_project);

        // Verificação de autorização usando o Gate
        if (Gate::denies('access-project', $project)) {
            return redirect()->route('projects.index')->with('error', 'Você não tem permissão para acessar este projeto.');
        }

        return view('project.reporting.index', compact('project'));
    }
}

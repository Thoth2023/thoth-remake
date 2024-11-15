<?php
/**
 * File: ReportingController.php
 * Author: Auri Gabriel
 *
 * Description: This is the controller class for the Reporting
 *
 * Date: 2023-11-12
 *
 * @see Export, Project
 */

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

class ExportController extends Controller
{
    public function index(string $id_project): View|RedirectResponse
    {
        $project = Project::findOrFail($id_project);

        // Verificação de autorização usando o Gate
        if (Gate::denies('access-project', $project)) {
            return redirect()->route('projects.index')->with('error', 'Você não tem permissão para acessar este projeto.');
        }

        return view('project.export.index', compact('project'));
    }
}

<?php

namespace App\Http\Controllers\Project\Conducting;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Database;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ProjectDatabase;
use Illuminate\Http\RedirectResponse;

class ImportDatabaseController extends Controller
{
    /**
     * Display a form to select a database for the project.
     *
     * @param  string $projectId
     * @return \Illuminate\View\View
     */
    public function selectDatabaseForm($projectId)
    {
        // Obter o projeto
        $project = Project::findOrFail($projectId);

        // Obter as databases pré-selecionadas em "planning" para o projeto
          $selectedDatabases = $project->planning->databases;

        // Obter todas as databases disponíveis
        $allDatabases = Database::all();

        // Passar as databases para a view
        return view('project.database.select', compact('project', 'selectedDatabases', 'allDatabases'));
    }

}

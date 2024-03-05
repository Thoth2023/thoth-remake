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
 *
 */

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

class ReportingController extends Controller
{
    public function index(string $id_project): View
    {
        $project = Project::findOrFail($id_project);
        return view('project.reporting.index', compact('project'));
    }
}

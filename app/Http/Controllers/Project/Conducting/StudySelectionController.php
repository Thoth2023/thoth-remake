<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudySelectionController extends Controller
{

    public function index(string $id_project) {

        return view('project.conducting.study_selection.index');

    }
}

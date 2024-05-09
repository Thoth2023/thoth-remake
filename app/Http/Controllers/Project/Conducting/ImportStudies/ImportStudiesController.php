<?php

namespace App\Http\Controllers\Project\Conducting\ImportStudies;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Database;
use App\Utils\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ProjectDatabase;
use Illuminate\Http\RedirectResponse;

class ImportStudiesController extends Controller
{
    /**
     * Display para a aba de Import Studies.
     */
    public function index(){
		return view('project.conducting.import-studies');
    }

}
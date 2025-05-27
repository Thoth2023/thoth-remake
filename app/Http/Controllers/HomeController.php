<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $total_projects = Project::count();
        $total_users = User::count();
        $total_finished_projects = Project::countFinishedProjects();
        $total_ongoing_projects = Project::countOngoingProjects();
        
        return view('pages.home', compact('total_projects', 'total_users', 'total_finished_projects', 'total_ongoing_projects'));
    }

    public function guest_home()
    {
        $total_projects = Project::count();
        $total_users = User::count();
        $total_finished_projects = Project::countFinishedProjects();
        $total_ongoing_projects = Project::countOngoingProjects();

        return view('pages.home', compact('total_projects', 'total_users', 'total_finished_projects', 'total_ongoing_projects'));
    }

   

    // public function ongoing_projects()
    // {
    //     $projects = Project::where('isFinished', '0')->get();
    //     return view('pages.ongoing_projects', compact('projects'));
    // }

    // public function finished_projects()
    // {
    //     $projects = Project::where('isFinished', 1)->get();
    //     return view('pages.finished_projects', compact('projects'));
    // }
    
    
}

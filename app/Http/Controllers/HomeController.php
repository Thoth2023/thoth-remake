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

        return view('pages.home', compact('total_projects', 'total_users'));
    }

    public function guest_home()
    {
        $total_projects = Project::count();
        $total_users = User::count();

        return view('pages.home', compact('total_projects', 'total_users'));
    }
}

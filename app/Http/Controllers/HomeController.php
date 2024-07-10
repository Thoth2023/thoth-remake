<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeManager;

class HomeController extends Controller
{
    public $homeObjs;
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
        $homeObjs = HomeManager::all();

        return view('pages.home',['homeObjs' => $homeObjs]);
    }

    public function guest_home()
    {
        $homeObjs = HomeManager::all();
        return view('pages.home',['homeObjs' => $homeObjs]);
    }
}

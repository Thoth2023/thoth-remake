<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeManagerController extends Controller
{
    
    public function index(){
        return view('pages.home-manager');
    }
}

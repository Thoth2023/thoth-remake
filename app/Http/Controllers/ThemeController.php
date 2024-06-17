<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    
    public function readCookie()
    {
       // return back()->withCookie(cookie('theme', 'dark', 60));
       return view('profile');
    }   
}

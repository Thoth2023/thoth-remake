<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the about page.
     */
    public function index()
    {
        return view('pages.about');
    }
}

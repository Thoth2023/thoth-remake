<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollaboratorsController extends Controller
{
    /**
     * Show the collaborators page.
     */
    public function index()
    {
        return view('pages.collaborators');
    }
}

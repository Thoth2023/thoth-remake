<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Show the terms page.
     */
    public function index()
    {
        return view('pages.terms');
    }
}

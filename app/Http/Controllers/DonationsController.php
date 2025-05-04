<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationsController extends Controller
{
    /**
     * Show the donations page.
     */
    public function index()
    {
        return view('pages.donations');
    }
} 
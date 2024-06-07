<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatabaseManagerController extends Controller
{
    public function index()
    {
        return view("pages.database-manager");
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqManagementController extends Controller
{
    public function index()
    {
        return view("pages.faq-management");
    }
}

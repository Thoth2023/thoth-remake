<?php


namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqManagementController extends Controller
{
    public function index()
    {
        $faq = Faq::all();
        return view('pages.faq-management', compact('faq'));
    }
}

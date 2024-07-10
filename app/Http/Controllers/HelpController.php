<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class HelpController extends Controller
{
    /**
     * Show the help page.
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('pages.help',['faqs' => $faqs]);
    }
}

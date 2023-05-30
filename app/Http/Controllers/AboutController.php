<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class About_Controller extends Pattern_Controller
{
	/**
	 *
	 */
	public function index()
	{
		return view('pages.about');
	}
}

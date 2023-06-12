<?php

namespace App\Http\Controllers;

use App\Models\SearchString;
use Illuminate\Http\Request;
use App\Models\Project;

class SearchStringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_project)
    {
        $project = Project::findOrFail($id_project);
        
        return view('planning.search-string', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SearchString $searchString)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SearchString $searchString)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SearchString $searchString)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SearchString $searchString)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LevelController extends Controller
{

    public function index()
    {
        $levels = Level::all();
        return view('superuser.levels-dashboard', compact('levels'));
    }

    public function create()
    {
        return view('levels-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Level::create($request->all());

        return redirect()->route('levels.index')->with('success', 'Level created successfully.');
    }

    public function edit(Level $level)
    {
        return view('levels-edit', compact('level'));
    }

    public function update(Request $request, Level $level)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $level->update($request->all());

        return redirect()->route('levels.index')->with('success', 'Level updated successfully.');
    }

    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()->route('levels.index')->with('success', 'Level deleted successfully.');
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Permission;
class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        return view('superuser.levels-dashboard', compact('levels'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('superuser.levels-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        

        Level::create($request->all());

        return redirect()->route('levels.index')->with('success', __('superuser/levels.create_message'));
    }

    public function show(Level $level)
    {
        return view('superuser.levels-show', compact('level'));
    }

    public function edit(Level $level)
    {
        return view('superuser.levels-edit', compact('level'));
    }

    public function update(Request $request, Level $level)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $level->update($request->all());

        return redirect()->route('levels.index')->with('success', __('superuser/levels.update_message'));
    }

    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()->route('levels.index')->with('success', __('superuser/levels.delete_message'));
    }
}

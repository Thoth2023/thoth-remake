<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminPanelController extends Controller
{
    public function index()
    {
        return view('admin.admin_panel');
    }

    public function editTexts()
    {
        $texts = json_decode(File::get(storage_path('app/public/texts.json')), true);
        return view('admin.edit_texts', compact('texts'));
    }

    public function updateTexts(Request $request)
    {
        $texts = [
            'home_text' => $request->input('home_text')
        ];

        File::put(storage_path('app/public/texts.json'), json_encode($texts));
        return redirect()->route('admin.panel')->with('success', 'Textos atualizados com sucesso!');
    }
}

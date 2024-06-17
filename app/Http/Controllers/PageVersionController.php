<?php


namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageVersion;
use Illuminate\Http\Request;

class PageVersionController extends Controller
{
    //buscar historico
    public function showHistory($pageId)
    {
        $pageVersions = PageVersion::where('page_id', $pageId)->orderByDesc('created_at')->get();
        return response()->json($pageVersions);
    }


    //restaução do historico
    public function restoreVersion($pageId, $versionId)
    {
        $pageVersion = PageVersion::find($versionId);
        if (!$pageVersion) {
            return response()->json(['error' => 'Page version not found'], 404);
        }

        $page = Page::find($pageId);
        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        $page->title = $pageVersion->title;
        $page->content = $pageVersion->content;
        $page->save();

        return response()->json($page);
    }

    //deleta
    public function deleteVersion($versionId)
    {
        $pageVersion = PageVersion::find($versionId);
        if (!$pageVersion) {
            return response()->json(['error' => 'Page version not found'], 404);
        }

        $pageVersion->delete();

        return response()->json(['message' => 'Page version deleted successfully']);
    }
}
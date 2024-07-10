<?php

namespace App\Http\Controllers;

use App\Models\PageVersion;
use App\Models\Faq;
use Illuminate\Http\Request;

class PageVersionController extends Controller
{
    public function showHistory($pageId)
    {
        $pageVersions = PageVersion::where('page_id', $pageId)->orderByDesc('created_at')->get();
        return response()->json($pageVersions);
    }

    public function restoreVersion($pageId, $versionId)
    {
        $pageVersion = PageVersion::find($versionId);
        if (!$pageVersion) {
            return response()->json(['error' => 'Page version not found'], 404);
        }

        if ($pageId === 'faq') {
            $faq = Faq::find($pageVersion->page_id);
            if ($faq) {
                $faq->update([
                    'question' => $pageVersion->title,
                    'response' => $pageVersion->content,
                ]);
            } else {
                Faq::create([
                    'question' => $pageVersion->title,
                    'response' => $pageVersion->content,
                    'page_id' => $pageVersion->page_id
                ]);
            }

            return response()->json($faq);
        }


        return response()->json(['message' => 'Restoration completed']);
    }

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

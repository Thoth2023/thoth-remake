<?php

namespace App\Http\Controllers;

use App\Models\NewsSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NewsSourceController extends Controller
{
    public function index()
    {
        $sources = NewsSource::orderBy('name')->get();
        return view('news-sources.index', compact('sources'));
    }

    public function create()
    {
        return view('news-sources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url'  => 'required|url|max:500',
            'more_link' => 'nullable|url|max:500',
            'active' => 'nullable|boolean',
        ]);

        // se o checkbox estiver marcado, vem como 'on', então:
        $validated['active'] = $request->has('active');

        try {
            $source = NewsSource::create($validated);

            // limpa cache individual (caso já exista)
            Cache::forget("news_{$source->id}");

            Log::info('Fonte de notícia criada com sucesso', [
                'id' => $source->id,
                'url' => $source->url,
                'active' => $source->active
            ]);

            return redirect()
                ->route('news-sources.index')
                ->with('success', __('pages/news-sources.created_successfully'));

        } catch (\Exception $e) {
            Log::error('Erro ao criar fonte de notícia', ['erro' => $e->getMessage()]);
            return back()->with('error', __('pages/news-sources.create_error'));
        }
    }

    public function edit(NewsSource $newsSource)
    {
        return view('news-sources.edit', compact('newsSource'));
    }

    public function update(Request $request, NewsSource $newsSource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url'  => 'required|url|max:500',
            'more_link' => 'nullable|url|max:500',
            'active' => 'nullable|boolean',
        ]);

        $validated['active'] = $request->has('active');

        try {
            $newsSource->update($validated);

            // limpa cache da fonte atualizada
            Cache::forget("news_{$newsSource->id}");

            Log::info('Fonte de notícia atualizada com sucesso', [
                'id' => $newsSource->id,
                'active' => $newsSource->active
            ]);

            return redirect()
                ->route('news-sources.index')
                ->with('success', __('pages/news-sources.updated_successfully'));

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar fonte de notícia', ['erro' => $e->getMessage()]);
            return back()->with('error', __('pages/news-sources.update_error'));
        }
    }

    public function toggle(NewsSource $newsSource)
    {
        try {
            $newsSource->update(['active' => !$newsSource->active]);

            $status = $newsSource->active
                ? __('pages/news-sources.activated')
                : __('pages/news-sources.deactivated');

            Cache::forget("news_{$newsSource->id}");

            Log::info('Status da fonte alterado', [
                'id' => $newsSource->id,
                'active' => $newsSource->active
            ]);

            return redirect()
                ->route('news-sources.index')
                ->with('success', $status);

        } catch (\Exception $e) {
            Log::error('Erro ao alternar status da fonte de notícia', ['erro' => $e->getMessage()]);
            return back()->with('error', __('pages/news-sources.toggle_error'));
        }
    }

    public function destroy(NewsSource $newsSource)
    {
        try {
            Cache::forget("news_{$newsSource->id}");
            $newsSource->delete();

            Log::info('Fonte de notícia deletada com sucesso', ['id' => $newsSource->id]);

            return redirect()
                ->route('news-sources.index')
                ->with('success', __('pages/news-sources.deleted_successfully'));

        } catch (\Exception $e) {
            Log::error('Erro ao deletar fonte de notícia', ['erro' => $e->getMessage()]);
            return back()->with('error', __('pages/news-sources.delete_error'));
        }
    }
}

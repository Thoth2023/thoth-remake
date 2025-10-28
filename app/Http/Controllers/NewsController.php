<?php

namespace App\Http\Controllers;

use App\Models\NewsSource;
use App\Services\NewsFetcherService;

class NewsController extends Controller
{
    protected $fetcher;

    public function __construct(NewsFetcherService $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function index()
    {
        $sources = NewsSource::all();
        $news = [];

        foreach ($sources as $source) {
            $news[$source->name] = $this->fetcher->fetchFromUrl($source->url);
        }

        return view('news.index', compact('news'));
    }
}


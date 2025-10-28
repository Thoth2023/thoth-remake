<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\NewsSource;
use App\Services\NewsFetcherService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected NewsFetcherService $newsFetcher;

    public function __construct(NewsFetcherService $newsFetcher)
    {
        $this->newsFetcher = $newsFetcher;
    }

    public function index()
    {
        $total_projects = Project::count();
        $total_users = User::count();
        $total_finished_projects = Project::countFinishedProjects();
        $total_ongoing_projects = Project::countOngoingProjects();

        // Busca somente as fontes ativas
        $sources = NewsSource::where('active', true)->get();
        $news = [];

        foreach ($sources as $source) {
            $news[$source->name] = Cache::remember(
                "news_{$source->id}",
                now()->addMinutes(30),
                fn () => $this->newsFetcher->fetchFromUrl($source->url)
            );
        }

        return view('pages.home', compact(
            'total_projects',
            'total_users',
            'total_finished_projects',
            'total_ongoing_projects',
            'sources',
            'news'
        ));
    }

    public function guest_home()
    {
        // Reaproveita a mesma lógica da index
        return $this->index();
    }
}

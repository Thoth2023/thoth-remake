<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchReferencesRequest;
use App\Services\SnowballingService;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\App;

class SnowballingController extends Controller
{
    protected $service;

    public function __construct(SnowballingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('snowballing');
    }

    public function fetchReferences(FetchReferencesRequest $request, SnowballingService $service)
    {
        try {
            $q = trim($request->input('q'));
            $result = $service->fetch($q);

            if (!$result) {
                $error = SnowballingService::isLikelyDoi($q)
                    ? __('snowballing.doi_not_found')
                    : __('snowballing.title_not_found');

                return back()->with('error', $error)->withInput();
            }

            return view('snowballing', [
                'q' => $q,
                'article' => $result['article'],
                'references' => $result['references'],
                'citations' => $result['citations'],
            ]);
        } catch (\Throwable $e) {
            // 🚨 Verifica se o erro é por limite de requisições
            if ($e->getCode() === 429 || str_contains($e->getMessage(), 'Too Many Requests')) {
                return back()->with('error', __('snowballing.too_many_requests'))->withInput();
            }

            Log::error('Erro inesperado ao buscar dados no SnowballingService', [
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', __('snowballing.unexpected_error'))->withInput();
        }
    }

}

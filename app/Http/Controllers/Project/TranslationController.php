<?php
namespace App\Http\Controllers\Project;

class TranslationController
{
    protected string $file;
    protected string $basePathAuth = 'auth';
    protected string $basePathNav = 'nav';
    protected string $basePathPages = 'pages';
    protected string $basePathProject = 'project';

    public function __construct(string $file = '')
    {
        $this->file = $file;
    }

    public function translateProject(string $key): string
    {
        $fullKey = "{$this->basePathProject}/{$this->file}.{$key}";
        return __($fullKey);
    }
    public function translateAuth(string $key): string
    {
        $fullKey = "{$this->basePathAuth}/{$this->file}.{$key}";
        return __($fullKey);
    }
    public function translateNav(string $key): string
    {
        $fullKey = "{$this->basePathNav}/{$this->file}.{$key}";
        return __($fullKey);
    }
    public function translatePages(string $key): string
    {
        $fullKey = "{$this->basePathPages}/{$this->file}.{$key}";
        return __($fullKey);
    }
}

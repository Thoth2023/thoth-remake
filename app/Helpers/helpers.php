<?php

use App\Http\Controllers\Project\TranslationController;

if (!function_exists('project_translate')) {
    function project_translate(string $key, string $file = ''): string
    {
        $translator = new \App\Http\Controllers\Project\TranslationController($file);
        return $translator->translateProject($key);
    }
}

if (!function_exists('auth_translate')) {
    function auth_translate(string $key, string $file = ''): string
    {
        $translator = new \App\Http\Controllers\Project\TranslationController($file);
        return $translator->translateAuth($key);
    }
}

if (!function_exists('nav_translate')) {
    function nav_translate(string $key, string $file = ''): string
    {
        $translator = new \App\Http\Controllers\Project\TranslationController($file);
        return $translator->translateNav($key);
    }
}

if (!function_exists('pages_translate')) {
    function pages_translate(string $key, string $file = ''): string
    {
        $translator = new \App\Http\Controllers\Project\TranslationController($file);
        return $translator->translatePages($key);
    }
}

// auth
if (!function_exists('translationChangePassword')) {
    function translationChangePassword(string $key): string
    {
        return auth_translate($key, 'change-password');
    }
}

if (!function_exists('translationLogin')) {
    function translationLogin(string $key): string
    {
        return auth_translate($key, 'login');
    }
}

if (!function_exists('translationRegister')) {
    function translationRegister(string $key): string
    {
        return auth_translate($key, 'register');
    }
}

if (!function_exists('translationResetPassword')) {
    function translationResetPassword(string $key): string
    {
        return auth_translate($key, 'reset-password');
    }
}

// nav
if (!function_exists('translationFooter')) {
    function translationFooter(string $key): string
    {
        return nav_translate($key, 'footer');
    }
}

if (!function_exists('translationNav')) {
    function translationNav(string $key): string
    {
        return nav_translate($key, 'nav');
    }
}

if (!function_exists('translationSide')) {
    function translationSide(string $key): string
    {
        return nav_translate($key, 'side');
    }
}

if (!function_exists('translationTopnav')) {
    function translationTopnav(string $key): string
    {
        return nav_translate($key, 'topnav');
    }
}

// pages
if (!function_exists('translationAbout')) {
    function translationAbout(string $key): string
    {
        return pages_translate($key, 'about');
    }
}

if (!function_exists('translationAddMember')) {
    function translationAddMember(string $key): string
    {
        return pages_translate($key, 'add_member');
    }
}

if (!function_exists('translationHelp')) {
    function translationHelp(string $key): string
    {
        return pages_translate($key, 'help');
    }
}

if (!function_exists('translationHome')) {
    function translationHome(string $key): string
    {
        return pages_translate($key, 'home');
    }
}

if (!function_exists('translationProfile')) {
    function translationProfile(string $key): string
    {
        return pages_translate($key, 'profile');
    }
}

if (!function_exists('translationProject')) {
    function translationProject(string $key): string
    {
        return pages_translate($key, 'project');
    }
}

if (!function_exists('translationTerms')) {
    function translationTerms(string $key): string
    {
        return pages_translate($key, 'terms');
    }
}

if (!function_exists('translationUserManager')) {
    function translationUserManager(string $key): string
    {
        return pages_translate($key, 'user-manager');
    }
}


//project
if (!function_exists('translationConducting')) {
    function translationConducting(string $key): string
    {
        return project_translate($key, 'conducting');
    }
}

if (!function_exists('translationCreate')) {
    function translationCreate(string $key): string
    {
        return project_translate($key, 'create');
    }
}

if (!function_exists('translationEdit')) {
    function translationEdit(string $key): string
    {
        return project_translate($key, 'edit');
    }
}

if (!function_exists('translationExport')) {
    function translationExport(string $key): string
    {
        return project_translate($key, 'export');
    }
}

if (!function_exists('translationHeader')) {
    function translationHeader(string $key): string
    {
        return project_translate($key, 'header');
    }
}

if (!function_exists('translationOverview')) {
    function translationOverview(string $key): string
    {
        return project_translate($key, 'overview');
    }
}

if (!function_exists('translationPlanning')) {
    function translationPlanning(string $key): string
    {
        return project_translate($key, 'planning');
    }
}

if (!function_exists('translationProjects')) {
    function translationProjects(string $key): string
    {
        return project_translate($key, 'projects');
    }
}

if (!function_exists('translationReporting')) {
    function translationReporting(string $key): string
    {
        return project_translate($key, 'reporting');
    }
}

if (!function_exists('translationSearch')) {
    function translationSearch(string $key): string
    {
        return project_translate($key, 'search');
    }
}



<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Thoth</title>

        <link rel="stylesheet" href="/css/styles.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    </head>
    <body>
        <header id="header">
            <span id="logo">
                <img src="/img/icone.svg">
                <span id="thoth-name-logo">Thoth</span>
            </span>
            <a class="header-link" id="about">About</a>
            <a class="header-link" id="help">Help</a>
            <form id="search-form">
                <input class="text-input" type="search" placeholder="Search in Thoth">
                <button class="button green-button align-center" type="submit">
                    <span class="material-symbols-outlined">search</span>
                    <span>Search</span>
                </button>
            </form>
            <span id="spacer"></span>
            @if (!Auth::check())
                <a class="header-link align-center">
                    <span class="material-symbols-outlined">
                        login
                    </span>
                    Sign in
                </a>
            @else
                <a class="header-link align-center">
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>
                    loggedinuser@outlook.com
                </a>
            @endif
            @if (!Auth::check())
                <a class="header-link align-center">
                    <span class="material-symbols-outlined">
                        person_add
                    </span>
                    Sign up
                </a>
            @else
                <a class="header-link align-center">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    Logout
                </a>
            @endif
        </header>
        @yield('content')
    </body>
</html>

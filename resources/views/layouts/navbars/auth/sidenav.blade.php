<aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main"
    style="z-index: 1"
>
    <div class="sidenav-header">
        <i
            class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true"
            id="iconSidenav"
        ></i>
        <a
            class="navbar-brand m-3"
            href="{{ Route::currentRouteName() != "page" ? route("projects.index") : "#" }}"
        >
            <img
                src="{{ asset("/img/logo.svg") }}"
                class="navbar-brand-img h-100"
                alt="main_logo"
            />
            <span class="ms-2 font-weight-bold title-thoth">Thoth</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0" />
    <div
        class="collapse navbar-collapse w-auto"
        id="sidenav-collapse-main"
        style="height: auto"
    >
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link {{ Route::currentRouteName() == "projects.index" ? "active" : "" }}"
                    href="{{ Route::currentRouteName() != "projects.index" ? route("projects.index") : "#" }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == "projects.index" ? "text-primary" : "text-dark" }} text-sm opacity-10 ni ni-single-copy-04"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ __("nav/nav.my_projects") }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link {{ Route::currentRouteName() == "profile" ? "active" : "" }}"
                    href="{{ Route::currentRouteName() != "profile" ? route("profile") : "#" }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == "profile" ? "text-primary" : "text-dark" }} text-sm opacity-10 ni ni-single-02"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ __("nav/nav.profile") }}
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link {{ Route::currentRouteName() == "about" ? "active" : "" }}"
                    href="{{ Route::currentRouteName() != "about" ? route("about") : "#" }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == "about" ? "text-primary" : "text-dark" }} text-sm opacity-10 ni ni-bulb-61"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ __("nav/nav.about") }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link {{ Route::currentRouteName() == "help" ? "active" : "" }}"
                    href="{{ Route::currentRouteName() != "help" ? route("help") : "#" }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == "help" ? "text-primary" : "text-dark" }} text-sm opacity-10 ni ni-satisfied"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ __("nav/nav.help") }}
                    </span>
                </a>
            </li>



            <li class="nav-item">
                <a
                    class="nav-link"
                    href="https://docs.thoth-slr.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i class="text-dark text-sm opacity-10 fas fa-book"></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {!! __("nav/nav.documentation") !!}
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link {{ Route::currentRouteName() == 'collaborators' ? 'active' : '' }}"
                    href="{{ Route::currentRouteName() != 'collaborators' ? route('collaborators') : '#' }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == 'collaborators' ? 'text-primary' : 'text-dark' }} text-sm opacity-10 ni ni-hat-3"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">
            {{ __('nav/nav.collaborators') }}
        </span>
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link {{ Route::currentRouteName() == 'donations' ? 'active' : '' }}"
                    href="{{ Route::currentRouteName() != 'donations' ? route('donations') : '#' }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == 'donations' ? 'text-primary' : 'text-dark' }} text-sm opacity-10 ni ni-credit-card"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">
            {{ __('nav/nav.donations') }}
        </span>
                </a>
            </li>


            <li class="nav-item">
                <a
                    class="nav-link {{ Route::currentRouteName() == "terms" ? "active" : "" }}"
                    href="{{ Route::currentRouteName() != "terms" ? route("terms") : "#" }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == "terms" ? "text-primary" : "text-dark" }} text-sm opacity-10 fas fa-file-contract"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {!! __("nav/nav.terms_and_conditions") !!}
                    </span>
                </a>
            </li>



            @if (Auth::user()->role == "SUPER_USER")
                <br />
                <h6
                    class="ps-4 ms-2 text-uppercase text-xl font-weight-bolder opacity-4"
                >
                    :: {{ __("nav/side.titulo-adm") }}
                </h6>
                <li class="nav-item">
                    <a
                        class="nav-link {{ Route::currentRouteName() == "database-manager" ? "active" : "" }}"
                        href="{{ Route::currentRouteName() != "database-manager" ? route("database-manager") : "#" }}"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="{{ Route::currentRouteName() == "database-manger" ? "text-primary" : "text-dark" }} text-sm opacity-10 fas fa-users-cog"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">
                            {{ __("nav/side.database_manager") }}
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ Route::currentRouteName() == "user-manager" ? "active" : "" }}"
                        href="{{ Route::currentRouteName() != "user-manager" ? route("user-manager") : "#" }}"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="{{ Route::currentRouteName() == "database-manger" ? "text-primary" : "text-dark" }} text-sm opacity-10 fas fa-users-cog"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">
                            {{ __("nav/side.user_manager") }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link {{ Route::currentRouteName() == "levels.index" ? "active" : "" }}"
                        href="{{ Route::currentRouteName() != "levels.index" ? route("levels.index") : "#" }}"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="{{ Route::currentRouteName() == "levels.index" ? "text-primary" : "text-dark" }} text-sm opacity-10 fas fa-layer-group"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">
                            {{ __("nav/side.levels_manager") }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'news-sources.index' ? 'active' : '' }}"
                       href="{{ Route::currentRouteName() != 'news-sources.index' ? route('news-sources.index') : '#' }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="{{ Route::currentRouteName() == 'news-sources.index' ? 'text-primary' : 'text-dark' }} text-sm opacity-10 fas fa-newspaper"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __("nav/side.news_sources") }}</span>
                    </a>
                </li>

            @endif
        </ul>
        <br/><br/>
    </div>
</aside>

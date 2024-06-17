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
            href="{{ Route::currentRouteName() != "page" ? route("home") : "#" }}"
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
                    class="nav-link {{ Route::currentRouteName() == "page" ? "active" : "" }}"
                    href="{{ Route::currentRouteName() != "page" ? route("home") : "#" }}"
                >
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                    >
                        <i
                            class="{{ Route::currentRouteName() == "page" ? "text-primary" : "text-dark" }} text-sm opacity-10 ni ni-tv-2"
                        ></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __("nav/side.home") }}</span>
                </a>
            </li>
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
                    <span class="nav-link-text ms-1">{{ __("nav/side.my_projects") }}</span>
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
                    <span class="nav-link-text ms-1">{{ __("nav/side.profile") }}</span>
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
                    <span class="nav-link-text ms-1">{{ __("nav/side.about_us") }}</span>
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
                    <span class="nav-link-text ms-1">{{ __("nav/side.help") }}</span>
                </a>
            </li>
            @if (Auth::user()->role == "SUPER_USER")
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
                        <span class="nav-link-text ms-1">{{ __("nav/side.database_manager") }}</span>
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
                        <span class="nav-link-text ms-1">{{ __("nav/side.user_manager") }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl bg-white text-dark mb-3
    {{ str_contains(Request::url(), 'virtual-reality') ? 'mt-3 mx-3 bg-primary' : '' }}"
    id="navbarBlur" data-scroll="false">
    <div id="top" class="container-fluid py-1 px-3">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5" href="javascript:;">{{ __('nav/nav.pages') }}</a>
                </li>
                <li class="breadcrumb-item text-sm active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $title }}</h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex align-items-center justify-content-between" id="navbar">


        {{-- Search Form --}}
            <div class="d-flex align-items-center flex-grow-1 me-3">
                <form action="/search-project" method="get" class="w-100">
                    <div class="input-group">
            <span class="input-group-text text-body">
                <i class="fas fa-search" aria-hidden="true"></i>
            </span>
                        <input type="text" name="searchProject" class="form-control"
                               placeholder="{{ __('nav/nav.search_in_thoth') }}">
                    </div>
                </form>
            </div>

            {{-- Navbar Items --}}
            <ul class="navbar-nav d-flex align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-compass-04 text-primary"></i>
                        <span class="nav-link-text">Snowballing com IA</span>
                    </a>
                </li>

                {{-- Sidenav toggle (mobile) --}}
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>

                {{-- Settings icon --}}
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                        <span>{{ __('nav/nav.settings') }}</span>
                    </a>
                </li>

                {{-- Notifications Dropdown --}}
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">{{ __('notification.new_message') }}</span> Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">{{ __('notification.new_album') }}</span> Travis Scott
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary me-3 my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.6" fill="#FFFFFF"></path>
                                            <path d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z" fill="#FFFFFF"></path>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            {{ __('notification.pyment_success') }}
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Logout --}}
                <li class="nav-item d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}" class="m-1 d-flex align-items-center">
                        @csrf
                        <button type="submit"
                                class="btn btn-link nav-link d-flex align-items-center p-0 m-1 text-decoration-none"
                                style="cursor: pointer; outline: none; box-shadow: none;">
                            <i class="fa fa-sign-out-alt me-1 ms-1"></i>
                            <span>{{ __('nav/nav.logout') }}</span>
                        </button>
                    </form>

            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

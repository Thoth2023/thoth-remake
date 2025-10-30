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
                    <a class="nav-link" href="{{ route('snowballing.index') }}">
                        <i class="ni ni-compass-04 text-primary"></i>
                        <span class="nav-link-text">{{ __('nav/nav.references') }}</span>
                    </a>
                </li>

                {{-- Sidenav toggle (mobile) --}}
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>

                {{-- Settings icon --}}
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:" class="nav-link p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                        {{ __('nav/nav.settings') }}
                    </a>
                </li>

                {{-- Notifications Dropdown --}}
                @livewire('notifications-bell')

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
                </li>

            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

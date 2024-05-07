<div class="fixed-plugin">
    <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Thoth Configurator</h5>
                <p>See our dashboard options.</p>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body pt-sm-3 pt-0 overflow-auto">
            <div>
                <h6 class="mb-1">Language Selection</h6>
            </div>
            <!-- Language Selector Dropdown -->
            <div class="dropdown">
                <a href="#" class="btn btn-secondary dropdown-toggle mb-0" data-bs-toggle="dropdown"
                    id="navbarDropdownMenuLink2">
                    {{ __('nav/nav.language') }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                    @foreach (config('localization.locales') as $locale)
                        <li>
                            <a class="dropdown-item" href="{{ route('localization', $locale) }}">
                                {{ $locale }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- End Language Selector Dropdown -->
            <!-- Sidebar Backgrounds -->
            <div>
                <h6 class="mb-0 mt-3">Sidebar Colors</h6>
            </div>
            <a href="javascript:void(0)" class="switch-trigger background-color">
                <div class="badge-colors my-2 text-start">
                    <span class="badge filter bg-gradient-primary active" data-color="primary"
                        onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-success" data-color="success"
                        onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-warning" data-color="warning"
                        onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-danger" data-color="danger"
                        onclick="sidebarColor(this)"></span>
                </div>
            </a>
            <!-- Sidenav Type -->
            <div class="mt-3">
                <h6 class="mb-0">Sidenav Type</h6>
                <p class="text-sm">Choose between 2 different sidenav types.</p>
            </div>
            <div class="d-flex">
                <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                    onclick="sidebarType(this)">White</button>
                <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default"
                    onclick="sidebarType(this)">Dark</button>
            </div>
            <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
            <!-- Navbar Fixed -->
            <div class="d-flex my-3">
                <h6 class="mb-0">Navbar Fixed</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
                </div>
            </div>
            <hr class="horizontal dark my-sm-4">
            <div class="mt-2 mb-5 d-flex">
                <h6 class="mb-0">Light / Dark</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                        onclick="darkMode(this)">
                </div>
            </div>

            <div class="w-100 text-center">
                <a href="https://github.com/Thoth2023/thoth2.0" class="btn btn-dark mb-0 me-2" target="_blank">
                    {{-- &amp;url2=https%3A%2F%2Fwww.updivision.com --}}
                    <i class="fab fa-github me-1" aria-hidden="true"></i> Thoth
                </a>
                <a href="https://www.lesse.com.br" class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-laravel me-1" aria-hidden="true"></i> Lesse
                </a>
            </div>
        </div>
    </div>
</div>

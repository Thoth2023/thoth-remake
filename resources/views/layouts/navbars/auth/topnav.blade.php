<!-- Navbar -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}"
    id="navbarBlur" data-scroll="false">
    <div id="top" class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">{{ __('nav/nav.pages') }}</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">{{ $title }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center ">
                <form action="/search-project" method="get">
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" name="searchProject" class="form-control"
                            placeholder="{{ __('nav/nav.search_in_thoth') }}">
                    </div>
                </form>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link text-white font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">{{ __('nav/nav.logout') }}</span>
                        </a>
                    </form>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
    <a href="javascript:;" class="nav-link text-white p-0 position-relative" id="dropdownMenuButton"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell cursor-pointer"></i>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="notification-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
        @endif
    </a>
        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton" style="max-height: 400px; overflow-y: auto;">
        @forelse(auth()->user()->notifications as $notification)
        <li class="mb-2 notification-item" data-notification-id="{{ $notification->id }}">
    <div class="d-flex align-items-center justify-content-between">
        <a class="dropdown-item border-radius-md flex-grow-1" href="{{ $notification->data['url'] }}">
            <div class="d-flex py-1">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-{{ $notification->data['color'] ?? 'primary' }} text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="{{ $notification->data['icon'] ?? 'fa fa-bell' }} text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                    <span class="font-weight-bold">{{ $notification->data['title'] }}</span>
                                </h6>
                                <p class="text-xs text-secondary mb-0">
                                    <i class="fa fa-clock me-1"></i>
                                    {{ $notification->data['time'] ?? $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </a>
                    <button class="btn btn-link text-danger delete-notification me-2" 
                data-notification-id="{{ $notification->id }}"
                title="Excluir notificação">
            <i class="fas fa-times"></i>
        </button>
                </div>
            </li>
        @empty
            <li class="mb-2">
                <div class="dropdown-item border-radius-md text-center">
                    <p class="text-sm text-secondary mb-0">{{ __('No notifications') }}</p>
                </div>
            </li>
        @endforelse
    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

@push('js')
<script>
document.querySelector('.dropdown-menu').addEventListener('click', async function(e) {
    if (e.target.closest('.delete-notification')) {
        e.preventDefault();
        const btn = e.target.closest('.delete-notification');
        const notificationId = btn.dataset.notificationId;
        
        if (confirm('Are you sure you want to delete this notification?')) {
            try {
                const response = await fetch(`/notifications/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Remove a notificação da lista
                    btn.closest('.notification-item').remove();
                    
                    // Atualiza o contador
                    const badge = document.querySelector('.notification-badge');
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count;
                    } else {
                        badge.remove();
                    }
                } else {
                    alert(data.message || 'Error deleting notification');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to delete notification');
            }
        }
    }
});
</script>
@endpush

@push('css')
<style>
    .delete-notification {
        padding: 0.5rem;
        opacity: 0;
        transition: opacity 0.2s;
    }
    
    .notification-item:hover .delete-notification {
        opacity: 1;
    }
    
    .notification-item {
        transition: background-color 0.2s;
    }
    
    .notification-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
</style>
@endpush
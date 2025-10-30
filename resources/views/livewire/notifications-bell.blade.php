<li class="nav-item dropdown pe-2 d-flex align-items-center">

    <a href="#" class="nav-link p-0" data-bs-toggle="dropdown">
        <i class="fa fa-bell position-relative">
            @if($notifications->count())
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle p-1 small">
                    {{ $notifications->count() > 9 ? '9+' : $notifications->count() }}
                </span>
            @endif
        </i>
    </a>

    <ul class="dropdown-menu dropdown-menu-end px-2 py-3"
        style="min-width: 480px; max-width: 560px; white-space: normal; word-break: break-word;">

        @forelse ($notifications as $n)
            @php
                // Rota conforme o tipo
                $link = match($n->type) {
                    'database_suggestion' => route('database-manager'),
                    'database_approved'   => route('database-manager'),
                    'project_invitation'  => route('projects.index'),
                    default               => '#'
                };

                // Ícone conforme o tipo
                $icon = match($n->type) {
                    'database_suggestion' => 'fa-database text-primary',
                    'database_approved'   => 'fa-check-circle text-success',
                    'project_invitation'  => 'fa-user-plus text-success',
                    default               => 'fa-bell text-secondary'
                };
            @endphp

            <li class="mb-2">

                <a href="#"
                   wire:click.prevent="markAsRead({{ $n->id }}, '{{ $link }}')"
                   class="dropdown-item border-radius-md d-flex align-items-center py-2">

                    <div class="me-3">
                        <i class="fa {{ $icon }} fa-lg"></i>
                    </div>

                    <div class="d-flex flex-column" style="max-width: 490px;">
                        <span class="{{ $n->read ? '' : 'fw-bold' }}" style="white-space: normal;">
                            {{ $n->translated_message }}
                        </span>
                        <small class="text-muted">
                            {{ $n->created_at->diffForHumans() }}
                        </small>
                    </div>
                </a>

            </li>

        @empty

            <li class="text-center text-muted py-2">
                {{ __('notification.empty') }}
            </li>

        @endforelse

        @if($notifications->count())
            <div class="text-center mt-2 px-2">
                <button wire:click="markAllAsRead"
                        class="btn btn-sm btn-outline-secondary w-100">
                    <i class="fa fa-check-double me-1"></i>
                    {{ __('notification.mark_all_read') }}
                </button>
            </div>
        @endif

    </ul>
</li>

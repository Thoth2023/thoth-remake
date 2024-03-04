<div class="card mb-4 pb-2" style="overflow: hidden;">
    <div class="card-header pb-0">
        <h6>{{ $header }}</h6>
    </div>
    <ul class="nav nav-tabs">
        @foreach($tabs as $tab)
            <li class="nav-item">
                <a class="nav-link {{ $tab['id'] === $activeTab ? 'active' : '' }}" id="{{ $tab['id'] }}" data-bs-toggle="tab" href="{{ $tab['href'] }}">{{ $tab['label'] }}</a>
            </li>
        @endforeach
    </ul>
</div>


@php
    // Escopo para isolar armazenamento/seletores (pode enviar $scope no include; senão usa o header)
    $scope = $scope ?? \Illuminate\Support\Str::slug($header ?? 'tabs');

    // Aba ativa enviada pelo include (ex.: "overall-info-tab") ou primeira aba
    $activeTab = $activeTab ?? ($tabs[0]['id'] ?? null);
@endphp

<div id="project-tabs-{{ $scope }}" class="card pb-2" style="overflow: hidden">
    <div class="card-header pb-0">
        <h6 class="text-lg mb-0 pb-0">{{ $header }}</h6>
        <hr class="py-0 m-0 mt-1 mb-3" style="background: #b0b0b0" />
    </div>

    <ul class="override px-4 container d-flex gap-2 justify-content-center nav nav-tabs">
        @foreach ($tabs as $tab)
            @php
                // id completo: "overall-info-tab"  | base: "overall-info"
                $baseId = str_replace('-tab', '', $tab['id']);
                $isDefault = $tab['id'] === $activeTab;
            @endphp
            <li class="nav-item">
                <a
                    class="nav-link text-secondary {{ $isDefault ? 'active active-tab' : 'inactive-tab' }}"
                    id="{{ $tab['id'] }}"
                    data-tab="{{ $baseId }}"
                    data-bs-toggle="tab"
                    href="{{ $tab['href'] }}"
                    role="tab"
                    aria-controls="{{ $baseId }}"
                    aria-selected="{{ $isDefault ? 'true' : 'false' }}"
                >
                    {{ $tab['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<script>
    (() => {
        const container = document.getElementById('project-tabs-@json($scope)');
        if (!container || typeof bootstrap === 'undefined' || !bootstrap.Tab) return;

        const storageKey = 'activeTabId:@json($scope)';
        const links = Array.from(container.querySelectorAll('.nav-link[data-bs-toggle="tab"]'));
        if (!links.length) return;

        // Recupera a aba ativa do storage (baseId), senão usa a enviada pelo Blade, senão a primeira
        const bladeDefaultBase = @json($activeTab ? str_replace('-tab', '', $activeTab) : null);
        let activeBaseId =
            sessionStorage.getItem(storageKey) ||
            bladeDefaultBase ||
            (links[0].getAttribute('data-tab') || null);

        // Mostra a aba desejada usando a API do Bootstrap
        const targetLink =
            container.querySelector(`.nav-link[data-tab="${activeBaseId}"]`) ||
            links[0];

        if (targetLink) {
            // Deixe o Bootstrap aplicar/remover .active/.show nos links e nas panes
            const tab = new bootstrap.Tab(targetLink);
            tab.show();
        }

        // Ao trocar de aba, salve o baseId no storage
        links.forEach(link => {
            link.addEventListener('shown.bs.tab', (ev) => {
                const baseId = ev.target.getAttribute('data-tab');
                if (baseId) sessionStorage.setItem(storageKey, baseId);
            });
        });
    })();
</script>

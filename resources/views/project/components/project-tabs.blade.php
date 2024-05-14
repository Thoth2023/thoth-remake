<div class="card pb-2" style="overflow: hidden">
    <div class="card-header pb-0">
        <h6 class="text-lg mb-0 pb-0">{{ $header }}</h6>
        <hr class="py-0 m-0 mt-1 mb-3" style="background: #b0b0b0" />
    </div>
    <ul class="override px-4 container d-flex gap-2 justify-content-center nav nav-tabs">
        @foreach ($tabs as $tab)

            <li class="nav-item">
                <a class="nav-link text-secondary {{ $tab["id"] === $activeTab ? "active" : "" }}"
                   id="{{ $tab["id"] }}"
                   data-tab="{{ str_replace("-tab", "", $tab["id"]) }}"
                   data-bs-toggle="tab"
                   href="{{ $tab["href"] }}">
                    {{ $tab["label"] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
<script>
    (function () {
        const applyTabStyles = (tab, tabs, activeTabId) => {
            tabs.forEach((t) => {
                const tabId = t.getAttribute('data-tab');
                t.classList.toggle('active', tabId === activeTabId);
                t.classList.toggle('inactive-tab', tabId !== activeTabId);
            });
            tab.classList.add('active-tab');
        };

        const setActiveTab = (tab, tabs) => {
            const tabId = tab.getAttribute('data-tab');
            applyTabStyles(tab, tabs, tabId);
            sessionStorage.setItem('activeTabId', tabId);
        };

        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.nav-link');
            const activeTabId = sessionStorage.getItem('activeTabId');

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => setActiveTab(tab, tabs));
            });

            if (activeTabId) {
                const activeTab = document.querySelector(`[data-tab="${activeTabId}"]`);
                if (activeTab) {
                    setActiveTab(activeTab, tabs); // Aplica o estilo quando a página é carregada
                }
            }
        });
    })();
</script>

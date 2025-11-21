<div class="card pb-2" style="overflow: hidden">
    <div class="card-header thoth-card-header mb-0 pb-0">
        {{-- EXTRA BUTTONS / HELPERS --}}
                <x-helpers.modal
                    target="help"
                    modalTitle="{{ $header }}"
                    modalContent="{!! $content !!}"
                />
        <hr class="py-0 m-0 mt-1 mb-3" style="background: #b0b0b0" />
    </div>
    <ul
        class="override px-4 container d-flex gap-2 justify-content-center nav nav-tabs"
    >
        @foreach ($tabs as $tab)
            <li class="nav-item">
                <a
                    class="nav-link text-secondary inactive-tab"
                    id="{{ $tab["id"] }}"
                    data-tab="{{ str_replace("-tab", "", $tab["id"]) }}"
                    data-bs-toggle="tab"
                    href="{{ $tab["href"] }}"
                >
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
                t.classList.toggle('active-tab', tabId === activeTabId);
            });
        };

        const setActiveTab = (tab, tabs) => {
            const tabId = tab.getAttribute('data-tab');
            sessionStorage.setItem('activeTabId', tabId);
            applyTabStyles(tab, tabs, tabId);
        };

        const tabs = document.querySelectorAll('.nav-link');
        let activeTabId = sessionStorage.getItem('activeTabId');

        if (!activeTabId) {
            activeTabId = 'overall-info';
        }

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => setActiveTab(tab, tabs));
        });

        /**
         * Simular um click com um atraso de 50ms na tab ativa
         * para mudar os cards da página.
         */
        document.addEventListener('DOMContentLoaded', () => {
            const activeTab = document.querySelector(
                `[data-tab="${activeTabId}"]`,
            );
            activeTab.click();
        });
    })();
</script>

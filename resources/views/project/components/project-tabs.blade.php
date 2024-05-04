<div class="card pb-2" style="overflow: hidden">
    <div class="card-header pb-0">
        <h6 class="text-lg mb-0 pb-0">{{ $header }}</h6>
        <hr class="py-0 m-0 mt-1 mb-3" style="background: #b0b0b0;">
    </div>
    <ul class="override px-4 container d-flex gap-2 justify-content-center nav nav-tabs">
        @foreach ($tabs as $tab)
            <li class="nav-item">
                <a
                    class="nav-link text-secondary {{ $tab["id"] === $activeTab ? "active" : "" }}"
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
        const setActiveTab = (tabs, activeTabId) => {
            tabs.forEach((t) =>
                t.classList.toggle(
                    'active',
                    t.getAttribute('data-tab') === activeTabId,
                ),
            );
        };

        const handleTabClick = (tab, tabs) => {
            const tabId = tab.getAttribute('data-tab');
            setActiveTab(tabs, tabId);
            sessionStorage.setItem('activeTabId', tabId);
        };

        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.nav-link');
            const activeTabId = sessionStorage.getItem('activeTabId');

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => handleTabClick(tab, tabs));
            });

            if (activeTabId) {
                const activeTab = document.querySelector(
                    `[data-tab="${activeTabId}"]`,
                );
                if (activeTab) activeTab.click();
            }
        })();
    })();
</script>

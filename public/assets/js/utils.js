/**
    This script is used to filter items based on the search input value.

    Usage:
        - Add the class `search-input` to the input element.
        - Add the attribute `data-target` to the input element with the value of the target element id.
        - Add the attribute `data-item` to the target element with the value of the target element id.

    Example:
        <input type="text" class="search-input" data-target="search-domains" placeholder="Search...">

        <div data-item="search-domains">  <-- Add the data-item with the value of the data-target
            <div class"d-flex">
                <div>Test</div>
                <span data-search>Item 1</span> <- It will search for this element
            </div>
            <div class"d-flex">
                <div>Test 2</div>
                <span data-search>Item 2</span> <- It will search for this element
            </div>
        </div>

    Note:
        You should use `class="search-input"` to the input element.
        You should use `data-item`, `data-target`, and `data-search` attributes to the elements.
        You should use the `data-search` attribute to the element you want to search for.
        The script will search for the text content of the element with the `data-search` attribute.
        The script will hide the element if the search term is not found in the element.
        The script will show the element if the search term is found in the element.
        The search is case insensitive.
 */
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.search-input')

    for (const input of inputs) {
        input.addEventListener('input', function () {
            const searchTerm = this.value.trim().toLowerCase()
            const targetId = this.getAttribute('data-target')
            const isTable = this.getAttribute('data-is-table')

            filterItems(searchTerm, targetId, isTable ? 'table-row' : 'block')
        })
    }

    function filterItems(searchTerm, targetId, displayType = 'block') {
        const items = document.querySelectorAll(`[data-item="${targetId}"]`);
        const filteredItems = Array.from(items).filter(
            (item) => item.textContent.trim().toLowerCase().includes(searchTerm.toLowerCase())
        )
        const childrenDataSearch = [];

        for (const item of filteredItems) {
            const elementsWithSearch = item.querySelectorAll('[data-search]');
            childrenDataSearch.push(...elementsWithSearch);
        }
        const empty = document.querySelector(`[data-empty="${targetId}"]`)

        if (empty) {
            if (searchTerm.length > 0 && childrenDataSearch.length === 0) {
                empty.style.display = 'block'
            } else {
                empty.style.display = 'none'
            }
        }

        for (const item of items) {
            if (filteredItems.includes(item)) {
                item.style.display = displayType
            } else {
                item.style.cssText = 'display: none !important'
            }
        }
    }
})

/**
 * Toast notification using SweetAlert2.
 */
function toasty({ message, type, toast = true, ...props }) {
    Swal.fire({
        toast,
        html: message,
        icon: type,
        showConfirmButton: false,
        showCloseButton: true,
        timerProgressBar: true,
        timer: 3_500, // 3.5 seconds
        position: !toast ? 'center' : 'bottom-end',
        customClass: {
            container: 'sweet-toast-container w-100',
            popup: 'z-3 px-3 py-2 rounded-3 w-100 w-sm-25',
        },
        ...props,
    });
}

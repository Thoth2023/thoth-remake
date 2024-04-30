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

            filterItems(searchTerm, targetId)
        })
    }

    function filterItems(searchTerm, targetId) {
        const items = Array.from(document.querySelectorAll(`[data-item="${targetId}"]`))
        const filteredItems = items.filter(item => item.textContent.trim().toLowerCase().includes(
            searchTerm))

        if (searchTerm.length > 0 && filteredItems.length === 0) {
            document.querySelector(`[data-empty="${targetId}"]`).style.display = 'block'
        } else {
            document.querySelector(`[data-empty="${targetId}"]`).style.display = 'none'
        }

        for (const item of items) {
            if (filteredItems.includes(item)) {
                item.style.display = 'block'
            } else {
                item.style.cssText = 'display: none !important'
            }
        }
    }
})

function _showToast({ title, message, type = 'success' }) {
    const toast = document.querySelector('[data-toast]')
    const toastTitle = document.querySelector('[data-toast-title]')
    const toastMessage = document.querySelector('[data-toast-message]')

    const colors = {
        success: 'text-success',
        danger: 'text-danger',
        warning: 'text-warning',
        info: 'text-info'
    }

    toastTitle.classList.remove('text-danger', 'text-warning', 'text-info', 'text-success')
    toastTitle.classList.add(colors[type])

    toastTitle.innerHTML = title
    toastMessage.innerHTML = message

    const element = new bootstrap.Toast(toast)
    element.show()
}

const toast = {
    success: (message, { title }) => _showToast({ title, message, type: 'success' }),
    error: (message, { title }) => _showToast({ title, message, type: 'danger' }),
    warning: (message, { title }) => _showToast({ title, message, type: 'warning' }),
    info: (message, { title }) => _showToast({ title, message, type: 'info' })
}

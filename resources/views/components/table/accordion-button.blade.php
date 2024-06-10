<button class="table-accordion-button" onclick="toggleAccordion(this)">
    <i class="fas fa-plus" style="cursor: pointer"></i>
</button>

@once
    <script>
        function toggleAccordion(button) {
            const content =
                button.parentElement.parentElement.nextElementSibling;

            if (!content?.getAttribute('data-accordion')) {
                throw new Error('Nenhum atributo data-accordion encontrado.');
                return;
            }

            if (
                content.style.display === 'none' ||
                content.style.display === ''
            ) {
                content.style.display = 'table-row';
            } else {
                content.style.display = 'none';
            }
        }
    </script>
@endonce

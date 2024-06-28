<button
    class="table-accordion-button"
    onclick="
        const content = this.parentElement.parentElement.nextElementSibling;

        if (!content?.getAttribute('data-accordion')) {
            throw new Error('Nenhum atributo data-accordion encontrado.');
        }
        if (content.style.display === 'none' || content.style.display === '') {
            content.style.display = 'table-row';
            this.querySelector('i').classList.remove('fa-plus');
            this.querySelector('i').classList.add('fa-minus');
        } else {
            content.style.display = 'none';
            this.querySelector('i').classList.remove('fa-minus');
            this.querySelector('i').classList.add('fa-plus');
        }
"
>
    <i class="fas fa-plus" style="cursor: pointer"></i>
</button>

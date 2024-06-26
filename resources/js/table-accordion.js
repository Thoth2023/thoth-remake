function toggleAccordion(button) {
  const content =
    button.parentElement.parentElement.nextElementSibling;

  if (!content?.getAttribute('data-accordion')) {
    throw new Error(
      'Nenhum atributo data-accordion encontrado.',
    );
  }

  if (
    content.style.display === 'none' ||
    content.style.display === ''
  ) {
    content.style.display = 'table-row';
    button.querySelector('i').classList.remove('fa-plus');
    button.querySelector('i').classList.add('fa-minus');
  } else {
    content.style.display = 'none';
    button.querySelector('i').classList.remove('fa-minus');
    button.querySelector('i').classList.add('fa-plus');
  }
}
const accordionItems = document.querySelectorAll('.accordion-item');

accordionItems.forEach(item => {
    const header = item.querySelector('.accordion-header');

    header.addEventListener('click', () => {
        const isOpen = item.classList.contains('show');

        accordionItems.forEach(otherItem => otherItem.classList.remove('show'));

        if (!isOpen) {
            item.classList.add('show');
        }
    });
});
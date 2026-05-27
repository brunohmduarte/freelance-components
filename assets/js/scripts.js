const accordionItems = document.querySelectorAll('.accordion-item');

accordionItems.forEach(accordion => {
    accordion.addEventListener('click', () => {
        accordion.classList.toggle('show');       
    });
});
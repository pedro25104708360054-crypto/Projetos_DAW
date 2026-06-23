document.addEventListener('DOMContentLoaded', () => {
    const dots = document.querySelectorAll('.carousel-dots span');
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            dots.forEach(item => item.classList.remove('active'));
            dot.classList.add('active');
            console.log(`Slide selecionado: ${index + 1}`);
        });
    });
});

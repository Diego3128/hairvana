// dropdown logic
document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.querySelector('.dropdown-toggle');
    const menu = document.querySelector('.dropdown-menu');

    toggleButton.addEventListener('click', (e) => {
        e.stopPropagation(); //stop propagation 
        menu.classList.toggle("hide");
    });

    // Close menu when clicking outside
    document.addEventListener('click', () => {
        if (!menu.classList.contains("hide")) menu.classList.add("hide");
    });
});

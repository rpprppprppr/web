if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

function init() {
    const list = document.getElementById('list-items');
    list.addEventListener('click', (event) => {
        const arrow = event.target.closest('[data-open]');
        if (arrow) {
            const parent = arrow.closest('[data-parent]');
            parent.classList.toggle('list-item_open');
        }
    });
}
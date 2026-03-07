import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

window.openModal = function(idNote, label) {
    document.getElementById('modal-id-note').value = idNote;
    document.getElementById('modal-label').textContent = label;
    document.getElementById('modal').classList.add('open');
}

window.closeModal = function() {
    document.getElementById('modal').classList.remove('open');
}

window.closeModalIfOverlay = function(e) {
    if (e.target === document.getElementById('modal')) window.closeModal();
}

window.filterTable = function() {
    const query = document.getElementById('search-input').value.toLowerCase();
    document.querySelectorAll('#notes-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
    });
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') window.closeModal(); });
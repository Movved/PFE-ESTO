document.addEventListener('DOMContentLoaded', function () {
    // Signaler modal
    const overlay = document.getElementById('modal');
    if (overlay) {
        function openModal(id, nom) {
            document.getElementById('modal-id-note').value = id;
            document.getElementById('modal-label').textContent = nom;
            overlay.classList.add('open');
        }

        function closeModal() {
            overlay.classList.remove('open');
        }

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.signaler-btn');
            if (btn) { openModal(btn.dataset.noteId, btn.dataset.noteName); return; }
            if (e.target.closest('#modal-close-btn') || e.target.closest('#modal-cancel-btn')) { closeModal(); return; }
            if (e.target === overlay) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    }

    // Voir réponse modal
    document.querySelectorAll('.voir-reponse-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('reponse-modal-sub').textContent = this.dataset.module;
            document.getElementById('reponse-modal-text').textContent = this.dataset.reponse;
            document.getElementById('reponse-modal').classList.add('active');
        });
    });
});

window.closeReponseModal = function () {
    const modal = document.getElementById('reponse-modal');
    if (modal) modal.classList.remove('active');
};
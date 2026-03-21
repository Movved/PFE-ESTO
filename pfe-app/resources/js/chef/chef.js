// ── Filieres modal ──
window.openFiliereAddModal  = () => document.getElementById('add-modal').classList.add('open');
window.closeFiliereAddModal = () => document.getElementById('add-modal').classList.remove('open');
window.openFiliereEditModal = (id, nom, desc) => {
    document.getElementById('edit-form').action     = `/chef/filieres/${id}`;
    document.getElementById('edit-sub').textContent = nom;
    document.getElementById('edit-nom').value       = nom;
    document.getElementById('edit-desc').value      = desc;
    document.getElementById('edit-modal').classList.add('open');
};
window.closeFiliereEditModal = () => document.getElementById('edit-modal').classList.remove('open');

// ── Modules modal ──
window.openModuleAddModal  = () => document.getElementById('add-modal').classList.add('open');
window.closeModuleAddModal = () => document.getElementById('add-modal').classList.remove('open');
window.openModuleEditModal = (id, code, nom, semestreId, enseignantId) => {
    document.getElementById('edit-form').action           = `/chef/modules/${id}`;
    document.getElementById('edit-modal-sub').textContent = nom;
    document.getElementById('edit-code').value            = code;
    document.getElementById('edit-nom').value             = nom;
    document.getElementById('edit-semestre').value        = semestreId;
    document.getElementById('edit-enseignant').value      = enseignantId;
    document.getElementById('edit-modal').classList.add('open');
};
window.closeModuleEditModal = () => document.getElementById('edit-modal').classList.remove('open');

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        window.closeFiliereAddModal?.();
        window.closeFiliereEditModal?.();
        window.closeModuleAddModal?.();
        window.closeModuleEditModal?.();
    }
});
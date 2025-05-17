<div id="deleteConfirmModal" class="delete-modal" style="display: none;">
    <div class="delete-modal-overlay"></div>
    <div class="delete-modal-content">
        <div class="delete-icon">
            <i class="fas fa-trash"></i>
        </div>
        <h3>Yakin Hapus Data Ini?</h3>
        <p>Apakah Anda yakin ingin menghapus data ini?<br>Tindakan ini tidak dapat dibatalkan.</p>
        <div class="delete-modal-actions">
            <button onclick="cancelDelete()" class="cancel-delete">Cancel</button>
            <button onclick="confirmDelete()" class="confirm-delete">Delete</button>
        </div>
    </div>
</div>

<script>
    let currentDeleteForm = null;

    function showDeleteConfirmation(form) {
        currentDeleteForm = form;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function cancelDelete() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
        currentDeleteForm = null;
    }

    function confirmDelete() {
        if (currentDeleteForm) {
            currentDeleteForm.submit();
        }
    }
</script>

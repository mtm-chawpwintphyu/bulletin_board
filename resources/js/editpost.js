document.addEventListener('DOMContentLoaded', function () {
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function () {
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('status').checked = false;
        });
    }
});

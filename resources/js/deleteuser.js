document.addEventListener('DOMContentLoaded', function () {
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
    const deleteUserForm = document.getElementById('deleteUserForm');

    const deleteUserId = document.getElementById('deleteUserId');
    const deleteUserName = document.getElementById('deleteUserName');
    const deleteUserEmail = document.getElementById('deleteUserEmail');
    const deleteUserPhone = document.getElementById('deleteUserPhone');
    const deleteUserDob = document.getElementById('deleteUserDob');
    const deleteUserAddress = document.getElementById('deleteUserAddress');
    const deleteUserType = document.getElementById('deleteUserType');

    const deleteButtons = document.querySelectorAll('.delete-button');
    const currentUserId = document.getElementById('currentUserId').value;

    deleteButtons.forEach(function (button) {
        const userId = button.getAttribute('data-user-id');
        if (userId === currentUserId) {
            button.disabled = true; 
            button.title = "You cannot delete the currently logged-in user";
        }
        button.addEventListener('click', function (event) {
            if (userId === currentUserId) {
                alert("You cannot delete the currently logged-in user.");
                return;
            }
            const userName = button.getAttribute('data-user-name');
            const userEmail = button.getAttribute('data-user-email');
            const userPhone = button.getAttribute('data-user-phone');
            const userDob = button.getAttribute('data-user-dob');
            const userAddress = button.getAttribute('data-user-address');
            const userType = button.getAttribute('data-user-type');

            deleteUserId.textContent = userId;
            deleteUserName.textContent = userName;
            deleteUserEmail.textContent = userEmail;
            deleteUserPhone.textContent = userPhone;
            deleteUserDob.textContent = userDob;
            deleteUserAddress.textContent = userAddress;
            deleteUserType.textContent = userType;

            deleteUserForm.action = `/users/${userId}`;

            const myModal = new bootstrap.Modal(deleteConfirmationModal);
            myModal.show();
        });
    });
});

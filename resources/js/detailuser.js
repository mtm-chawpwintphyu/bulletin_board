document.addEventListener('DOMContentLoaded', function () {
    const userDetailsModal = document.getElementById('userDetailsModal');

    if (userDetailsModal) {
        userDetailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            if (button) {

                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userEmail = button.getAttribute('data-user-email');
                const userPhone = button.getAttribute('data-user-phone');
                const userDob = button.getAttribute('data-user-dob');
                const userAddress = button.getAttribute('data-user-address');
                const userType = button.getAttribute('data-user-type');
                const userCreatedAt = button.getAttribute('data-user-created-at');
                const userUpdatedAt = button.getAttribute('data-user-updated-at');
                const userCreatedUser = button.getAttribute('data-user-created-user');
                const userUpdatedUser = button.getAttribute('data-user-updated-user');
                const userUpdatedUserId = button.getAttribute('data-user-updated-user-id');
                const userProfile = button.getAttribute('data-user-profile');

                console.log(userProfile);
                document.getElementById('modalUserId').textContent = userId;
                document.getElementById('modalUserName').textContent = userName;
                document.getElementById('modalUserEmail').textContent = userEmail;
                document.getElementById('modalUserPhone').textContent = userPhone;
                document.getElementById('modalUserDob').textContent = userDob;
                document.getElementById('modalUserAddress').textContent = userAddress;
                document.getElementById('modalUserType').textContent = userType;
                document.getElementById('modalUserCreatedAt').textContent = userCreatedAt;
                document.getElementById('modalUserUpdatedAt').textContent = userUpdatedAt;
                document.getElementById('modalUserCreatedUser').textContent = userCreatedUser;

                if (userUpdatedUserId == 1) {
                    document.getElementById('modalUserUpdatedUser').textContent = 'Admin';
                } else {
                    document.getElementById('modalUserUpdatedUser').textContent = userUpdatedUser;
                }

                const profileImage = userProfile
                    ? `<img src="${userProfile}" alt="Profile Picture" class="img-fluid" />`
                    : "No profile available.";

                document.getElementById('modalUserProfile').innerHTML = profileImage;
            }
        });
    }
});

document.getElementById('toggle-password').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }
});

document.getElementById('toggle-password-confirm').addEventListener('click', function() {
    const confirmPasswordField = document.getElementById('password_confirmation');
    const eyeIconConfirm = document.getElementById('eye-icon-confirm');

    if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        eyeIconConfirm.classList.remove('fa-eye-slash');
        eyeIconConfirm.classList.add('fa-eye');
    } else {
        confirmPasswordField.type = 'password';
        eyeIconConfirm.classList.remove('fa-eye');
        eyeIconConfirm.classList.add('fa-eye-slash');
    }
});





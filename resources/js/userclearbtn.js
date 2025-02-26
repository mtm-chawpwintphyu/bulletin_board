document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('reset-btn').addEventListener('click', function () {
        let form = this.closest('form');
    
        form.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], select').forEach(function (input) {
            input.value = '';
        });

        form.querySelectorAll('input[type="file"]').forEach(function (fileInput) {
            fileInput.value = '';
        });

        let imageContainer = form.querySelector('.profile-picture-container');
        if (imageContainer) {
            imageContainer.innerHTML = '';
        }
       
        let oldProfileImg = document.getElementById('old-profile-img');
        let oldProfileMsg = document.getElementById('old-profile-msg');
        
        if (oldProfileImg) {
            oldProfileImg.src = '';  
            oldProfileImg.alt = 'No profile picture uploaded'; 
        }
        
        if (oldProfileMsg) {
            oldProfileMsg.style.display = 'block'; 
        }
    });
});
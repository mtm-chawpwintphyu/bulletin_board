document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function () {

        const postId = this.getAttribute('data-post-id');
        const postTitle = this.getAttribute('data-post-title');
        const postDescription = this.getAttribute('data-post-description');
        const postStatus = this.getAttribute('data-post-status');

        console.log(postId);

        document.getElementById('postId').textContent = postId;
        document.getElementById('postTitle').textContent = postTitle;
        document.getElementById('postDescription').textContent = postDescription;
        const statusText = postStatus == 1 ? 'Active' : 'Inactive';
        document.getElementById('postStatus').textContent = statusText;

        const form = document.getElementById('deleteForm');
        if (postId) {
            form.action = '/posts/' + postId;
        } else {
            console.error("Post ID is missing!");
        }
    });
});


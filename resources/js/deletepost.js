document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function () {

        const postId = this.getAttribute('data-post-id');
        const postTitle = this.getAttribute('data-post-title');
        const postDescription = this.getAttribute('data-post-description');
        const postStatus = this.getAttribute('data-post-status');

        console.log(postId);
        const truncatedDescription = truncateDescription(postDescription, 100);

        document.getElementById('postId').textContent = postId;
        document.getElementById('postTitle').textContent = postTitle;
        document.getElementById('postDescription').textContent = truncatedDescription;
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

// Function to truncate description to 'n' words and append '...' if necessary
function truncateDescription(description, wordLimit) {
    const words = description.split(' ');
    if (words.length > wordLimit) {
        return words.slice(0, wordLimit).join(' ') + '...';
    }
    return description;
}

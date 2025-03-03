document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.post-title').forEach(function (element) {
        element.addEventListener('click', function (event) {

            const postId = event.target.getAttribute('data-post-id');
            const postTitle = event.target.getAttribute('data-post-title');
            const postDescription = event.target.getAttribute('data-post-description');
            const postStatus = event.target.getAttribute('data-post-status');
            const postCreatedBy = event.target.getAttribute('data-post-created-by');
            const postCreatedAt = event.target.getAttribute('data-post-created-at');
            const postUpdatedBy = event.target.getAttribute('data-post-updated-by');
            const postUpdatedAt = event.target.getAttribute('data-post-updated-at');

            document.getElementById('modalPostId').textContent = postId;
            document.getElementById('modalPostTitle').textContent = postTitle;

            const truncatedDescription = truncateDescription(postDescription, 100);
            document.getElementById('modalPostDescription').textContent = truncatedDescription;

            const statusText = postStatus == 1 ? 'Active' : 'Inactive';
            document.getElementById('modalPostStatus').textContent = statusText;
            document.getElementById('modalPostStatus').style.color = postStatus == 1 ? 'green' : 'red';
            document.getElementById('modalPostCreatedBy').textContent = postCreatedBy;
            document.getElementById('modalPostCreatedAt').textContent = postCreatedAt;
            document.getElementById('modalPostUpdatedBy').textContent = postUpdatedBy;
            document.getElementById('modalPostUpdatedAt').textContent = postUpdatedAt;

            var myModal = new bootstrap.Modal(document.getElementById('postDetailsModal'));
            myModal.show();
        });
    });
});

// Function to truncate description to n words
function truncateDescription(description, wordLimit) {
    const words = description.split(' ');
    if (words.length > wordLimit) {
        return words.slice(0, wordLimit).join(' ') + '...';
    }
    return description;
}

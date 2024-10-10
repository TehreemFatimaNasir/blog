<?php
include 'db.php'; // Include your database connection file

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postId = $conn->real_escape_string($postId); // Sanitize input

    // First, delete comments associated with the post
    $deleteCommentsSql = "DELETE FROM comments WHERE post_id = '$postId'";
    $conn->query($deleteCommentsSql); // Execute comment deletion

    // Then, delete the post
    $deletePostSql = "DELETE FROM posts WHERE id = '$postId'";
    if ($conn->query($deletePostSql) === TRUE) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post: " . $conn->error;
    }

    // Redirect to the main page after a short delay (optional)
    header("Refresh: 2; URL=index.php"); // Change 'index.php' to your main posts page
} else {
    echo "Post ID not specified.";
}

// Close the connection if necessary
$conn->close();
?>

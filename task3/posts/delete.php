<?php
session_start();
require_once "../config/db.php";

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Check if post ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Post deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting post.";
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid post ID.";
}

$conn->close();

// Redirect to post list
header("Location: index.php");
exit();

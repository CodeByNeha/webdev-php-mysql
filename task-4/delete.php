<?php
include 'auth.php';
include 'db.php';

if ($_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid ID.");
}

$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>

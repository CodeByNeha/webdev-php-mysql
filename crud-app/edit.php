<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $pdo->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->execute([$title, $content, $id]);
    header("Location: read.php");
    exit();
}
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=?");
$stmt->execute([$id]);
$post = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Post</h1>
    <form method="POST">
        <input type="text" name="title" value="<?= $post['title'] ?>" required>
        <textarea name="content" required><?= $post['content'] ?></textarea>
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
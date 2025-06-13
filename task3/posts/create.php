<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if ($title && $content) {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        header("Location: index.php");
        exit();
    } else {
        $error = "Both title and content are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>
<div class="container">
  <div class="card shadow p-4">
    <h2 class="mb-3">Create New Post</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="6" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">Create</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
</body>
</html>

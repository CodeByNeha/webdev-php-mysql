<?php include 'includes/db.php'; include 'includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] == 'viewer') {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);

  $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
  $stmt->execute([$title, $content]);
  header("Location: dashboard.php");
}
?>

<h2>Create New Post</h2>
<form method="POST" onsubmit="return validatePostForm()" novalidate>
  <div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Content</label>
    <textarea name="content" rows="6" class="form-control" required></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php include 'includes/footer.php'; ?>

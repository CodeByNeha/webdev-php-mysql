<?php include 'includes/db.php'; include 'includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] == 'viewer') {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $update = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
  $update->execute([$title, $content, $id]);
  header("Location: dashboard.php");
}
?>

<h2>Edit Post</h2>
<form method="POST" onsubmit="return validatePostForm()" novalidate>
  <div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
  </div>
  <div class="mb-3">
    <label>Content</label>
    <textarea name="content" rows="6" class="form-control" required><?= htmlspecialchars($post['content']) ?></textarea>
  </div>
  <button type="submit" class="btn btn-warning">Update</button>
</form>

<?php include 'includes/footer.php'; ?>

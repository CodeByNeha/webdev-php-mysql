<?php include 'includes/db.php'; include 'includes/header.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$limit = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$posts = $pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT $start, $limit");
$posts->execute();
$rows = $posts->fetchAll();

$total = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$pages = ceil($total / $limit);
?>

<h2>Welcome <?= $_SESSION['user']['username'] ?>!</h2>
<p>Role: <strong><?= $_SESSION['user']['role'] ?></strong></p>

<form method="GET" action="search.php" class="mb-3">
  <input type="text" name="query" class="form-control" placeholder="Search posts by title...">
</form>

<?php foreach ($rows as $row): ?>
  <div class="card mb-3">
    <div class="card-body">
      <h5><?= htmlspecialchars($row['title']) ?></h5>
      <p><?= substr(strip_tags($row['content']), 0, 100) ?>...</p>
      <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View</a>

      <?php if ($_SESSION['user']['role'] != 'viewer'): ?>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
      <?php endif; ?>

      <?php if ($_SESSION['user']['role'] == 'admin'): ?>
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete post?')" class="btn btn-sm btn-danger">Delete</a>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>

<nav>
  <ul class="pagination justify-content-center">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <li class="page-item <?= $page == $i ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>

<?php include 'includes/footer.php'; ?>

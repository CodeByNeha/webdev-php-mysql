<?php include 'includes/db.php'; include 'includes/header.php';

$query = trim($_GET['query'] ?? '');
$results = [];

if ($query) {
  $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE ?");
  $stmt->execute(["%$query%"]);
  $results = $stmt->fetchAll();
}
?>

<h2>Search Results for "<?= htmlspecialchars($query) ?>"</h2>

<?php if (count($results) > 0): ?>
  <?php foreach ($results as $row): ?>
    <div class="card mb-3">
      <div class="card-body">
        <h5><?= htmlspecialchars($row['title']) ?></h5>
        <p><?= substr(strip_tags($row['content']), 0, 100) ?>...</p>
        <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View</a>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No posts found.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>

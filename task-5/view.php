<?php include 'includes/db.php'; include 'includes/header.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();
?>

<h2><?= htmlspecialchars($post['title']) ?></h2>
<p class="text-muted"><?= date('d M Y', strtotime($post['created_at'])) ?></p>
<div><?= nl2br(htmlspecialchars($post['content'])) ?></div>

<a href="dashboard.php" class="btn btn-secondary mt-3">Back</a>

<?php include 'includes/footer.php'; ?>

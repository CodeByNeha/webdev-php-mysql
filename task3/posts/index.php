<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$search = "";
$limit = 3; // Posts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $like = "%{$search}%";

    // Total count for search
    $stmt = $conn->prepare("SELECT COUNT(*) FROM posts WHERE title LIKE ? OR content LIKE ?");
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $stmt->bind_result($total_posts);
    $stmt->fetch();
    $stmt->close();

    // Fetch filtered posts
    $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ssii", $like, $like, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Total count without search
    $count_result = $conn->query("SELECT COUNT(*) as count FROM posts");
    $total_posts = $count_result->fetch_assoc()['count'];

    // Fetch posts
    $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
}

$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<div class="container mt-5">
  <!-- Flash Message -->
  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
      <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
  <?php endif; ?>

  <!-- Search bar -->
<form action="" method="GET" class="mb-4">
  <div class="input-group">
    <input type="text" name="search" class="form-control form-control-lg" placeholder="Search posts..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button class="btn btn-primary" type="submit">Search</button>
  </div>
</form>


  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>All Blog Posts</h2>
    <a href="create.php" class="btn btn-success">+ Create New Post</a>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</td>
            <td><?= $row['created_at'] ?></td>
            <td>
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
              <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
      <nav>
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>

  <?php else: ?>
    <div class="alert alert-warning">No posts found. <a href="create.php">Create one now</a>.</div>
  <?php endif; ?>
</div>

</body>
</html>

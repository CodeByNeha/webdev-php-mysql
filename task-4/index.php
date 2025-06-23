<?php include 'auth.php'; include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Post List</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2 class="mb-3">Welcome, <?= $_SESSION['username'] ?> (<?= $_SESSION['role'] ?>)</h2>

<form class="d-flex mb-3" method="GET">
    <input type="text" class="form-control me-2" name="search" placeholder="Search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<?php if ($_SESSION['role'] !== 'viewer'): ?>
    <a href="create.php" class="btn btn-success mb-3">➕ Add Post</a>
<?php endif; ?>

<a href="logout.php" class="btn btn-secondary mb-3 float-end">Logout</a>

<?php
$search = $_GET['search'] ?? '';
$limit = 5;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

$searchParam = "%$search%";
$stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? LIMIT ?, ?");
$stmt->bind_param("ssii", $searchParam, $searchParam, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0): ?>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Title</th><th>Content</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['content']) ?></td>
            <td>
                <?php if ($_SESSION['role'] !== 'viewer'): ?>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                <?php endif; ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">🗑️ Delete</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>

<?php
$count_stmt = $conn->prepare("SELECT COUNT(*) FROM posts WHERE title LIKE ? OR content LIKE ?");
$count_stmt->bind_param("ss", $searchParam, $searchParam);
$count_stmt->execute();
$count_stmt->bind_result($total);
$count_stmt->fetch();
$total_pages = ceil($total / $limit);
?>

<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

</body>
</html>

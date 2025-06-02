<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Posts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>All Posts</h1>
    <a href="create.php">Add New Post</a> | <a href="logout.php">Logout</a>
    <hr>
    <?php
    session_start();
    include 'db.php';
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        echo "<div class='post'>
                <h2>{$row['title']}</h2>
                <p>{$row['content']}</p>
                <div class='actions'>
                    <a href='edit.php?id={$row['id']}'>Edit</a> | 
                    <a href='delete.php?id={$row['id']}'>Delete</a>
                </div>
              </div><hr>";
    }
    ?>
</div>
</body>
</html>
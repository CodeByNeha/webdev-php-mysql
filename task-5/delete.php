<?php include 'includes/db.php';

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);
header("Location: dashboard.php");
?>

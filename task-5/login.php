<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  // Check if user exists
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    // Valid login
    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username'],
      'role' => $user['role']
    ];
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<div class="container mt-5" style="max-width: 500px;">
  <h2 class="mb-4">Login</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <?php if (isset($_GET['registered'])): ?>
    <div class="alert alert-success">Registration successful. Please log in.</div>
  <?php endif; ?>

  <form method="POST" onsubmit="return validateLoginForm()" novalidate>
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Login</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>

<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
  $stmt->execute([$username, $email, $password, $role]);

  header("Location: login.php?registered=1");
  exit;
}
?>

<h2>Register</h2>
<form method="POST" onsubmit="return validateRegisterForm()" novalidate>
  <div class="mb-3">
    <label>Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Role</label>
    <select name="role" class="form-select" required>
      <option value="">Select Role</option>
      <option value="admin">Admin</option>
      <option value="editor">Editor</option>
      <option value="viewer">Viewer</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>

<?php include 'includes/footer.php'; ?>

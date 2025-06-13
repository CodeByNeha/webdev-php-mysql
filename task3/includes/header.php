<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Modern Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../posts/index.php">
       MyBlog
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
      <ul class="navbar-nav align-items-center">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item me-3 text-white">
            <span class="nav-link disabled" style="color: #ccc;">
              👋 Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
            </span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm" href="../auth/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm" href="../auth/login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Pull values safely
$name = $_SESSION['name'] ?? "Guest";
$profileimg = $_SESSION['profileimg'] ?? "default.png";

// Ensure fallback
if (empty($profileimg)) {
  $profileimg = "default.png";
}
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark header">
  <div class="container container-fluid">
    <img src="/shopping_cart/images/logo.png" class="navbar-brand header__logo" alt="logo" id="logo">
    <a id="logo-anch" class="navbar-brand" href="#"><strong>Morgan Limited</strong></a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mNavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/shopping_cart/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/shopping_cart/signup.php">Sign Up</a></li>
        <li class="nav-item"><a class="nav-link" href="/shopping_cart/loginpage.php">Login</a></li>
      </ul>

      <div class="nav_profile">
        <img class="profile-imgnav"
          src="/shopping_cart/images/<?php echo $profileimg; ?>"
          alt="Profile">
        <span class="mythumbnail"><?php echo htmlspecialchars($name); ?></span>
      </div>
    </div>
  </div>
</nav>
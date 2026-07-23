<?php

echo '
<nav class="navbar navbar-expand-sm navbar-dark bg-dark header">
    <div class="container container-fluid ">
      <img src="images/logo.png" class="navbar-brand header__logo" alt="logo" id="logo"><a id="logo-anch" class="navbar-brand" href="#"><strong>Morgan Limited</strong></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mNavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="/shopping_cart/index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/shopping_cart/signup.php">Signup</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/shopping_cart/loginpage.php">Login</a>
          </li>
        </ul>

      </div>
    </div>
  </nav>
';

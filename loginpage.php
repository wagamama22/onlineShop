<?php
session_start();
if (!@include("connect.php")) {
  echo "dataase connection not enabled";
}
?>



<!DOCTYPE html>
<html lang="en">

<?php require_once __DIR__ . "/generalheader.php"  ?>

<body class="mymain_all">
  <?php require_once __DIR__ . "/general_navbar.php"  ?>
  <main>
    <section class="container intro  gapSpace ">
      <h5 class="intro__h1"><strong>Login Now</strong></h5>

    </section>
    <section class=" gapSpace container">

      <div class="allforms">
        <div class="formclass__login gapSpace">
          <?php if (isset($_SESSION['error'])): ?>
            <div class="display_error">
              <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
              ?>
            </div>
          <?php endif; ?>
          <?php if (isset($_SESSION['success'])): ?>
            <div class="display_success">
              <?php
              echo $_SESSION['success'];
              unset($_SESSION['success']);
              ?>
            </div>
          <?php endif; ?>
          <form class="final_form" action="login.php" method="post">
            <input type="text" name="emailphone" id="emph" placeholder="Email or Phone Number">
            <br><br>
            <input type="password" name="skey" id="sk" placeholder="Password">
            <br><br>
            <input type="submit" value="Login" class="mybtn">
          </form>
        </div>
      </div>
    </section>
  </main>
  <?php require_once __DIR__ . "/footer.php"  ?>
  <script src="script.js"></script>

</body>

</html>
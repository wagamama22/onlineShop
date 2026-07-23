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
    <section class="container intro gapSpace">
      <h4 class="intro__h1"><strong>Sign up Now</strong></h4>
      <h5 class="intro__h2">Create an Account with Morgan Online Shop</h5>
    </section>
    <section class="container">
      <div class="allforms">
        <div class="formclass gapSpace">
          <?php if (isset($_SESSION['error'])): ?>
            <div class="display_error">
              <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
              ?>
            </div>
          <?php endif; ?>
          <form class="final_form" action="register.php" method="post">
            <input type="text" name="fname" id="fn" placeholder="First Name">
            <br><br>
            <input type="text" name="lname" id="ln" placeholder="last Name">
            <br><br>
            <input type="text" name="email" id="email" placeholder="Email Address">
            <br><br>
            <input type="password" name="skey" id="skey" placeholder="Password">
            <br><br>
            <input type="text" name="pnumber" id="pn" placeholder="Phone Number">
            <br><br>
            <select id="rol" name="role" required>
              <option>--Select User Type--</option>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
            <br><br>
            <input type="submit" value="Register" class="mybtn">
          </form>
        </div>
      </div>
    </section>
  </main>
  <?php require_once __DIR__ . "/footer.php"  ?>
  <script src="script.js"></script>

</body>

</html>
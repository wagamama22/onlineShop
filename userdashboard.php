<?php
session_start();
if (!@include("connect.php")) {
  echo "dataase connection not enabled";
}

//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: loginpage.php");
  exit;
}
$uid = $_SESSION['id'];
// echo "user id: {$uid}";
require_once __DIR__ . "/myprofile.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once __DIR__ . "/generalheader.php"  ?>

<body>
  <?php require_once __DIR__ . "/userdashboard_navbar.php"  ?>

  <div class="dashboard-wrapper">

    <div class="profile-box">
      <div>
        <?php if (isset($_SESSION['success'])): ?>
          <div class="display_success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
          </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="display_error">
            <?php
            echo $_SESSION['error'];
            ?>
          </div>
        <?php endif; ?>
      </div>

      <h2 class="profile-name">

      </h2>

      <?php
      // fetch order that has been added to morgan_table using the logged in user_id and order_id
      $sql = "SELECT * FROM morgan_cart WHERE user_id = ?";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $uid);
      mysqli_stmt_execute($stmt);
      $order = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($order) === 0) {
        $_SESSION['error'] = "You have no pending or paid orders";
        header("Location: userdashboard.php");
        exit;
      }

      while ($myorders = mysqli_fetch_assoc($order)) {
        //print_r($myorders);
      }
      ?>

      <div class="dash-form final_form">
        <a href="pendingorders.php" class="mybtn skip-btn">Pending Orders</a>
        <a href="paidorders.php" class="mybtn skip-btn">Paid Orders</a>
        <a href="index.php" class="mybtn skip-btn">Continue Shopping</a>
      </div>
      <form action="logout.php" method="post" class="dash-form">
        <input type="submit" value="Logout" class="mybtn logout-btn">
      </form>
    </div>

  </div>

  <?php require_once __DIR__ . "/footer.php"  ?>
  <script src="script.js"></script>

</body>


</html>
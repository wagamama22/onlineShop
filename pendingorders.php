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
// echo "userid: {$uid}";
$orderstatus = "pending";
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
            unset($_SESSION['error']);
            ?>
          </div>
        <?php endif; ?>
      </div>

      <h2 class="profile-name">

      </h2>

      <?php
      // fetch order that has been added to morgan_table using the logged in user_id and order_id
      $sql = "SELECT * FROM morgan_cart WHERE user_id = ? AND order_status=?";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "is", $uid, $orderstatus);
      mysqli_stmt_execute($stmt);
      $order = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($order) === 0) {
        $_SESSION['error'] = "order not found";
        header("Location: pendingorders.php");
        exit;
      }

      while ($myorders = mysqli_fetch_assoc($order)) {
        //print_r($myorders);
      ?>
        <h5>Product Name: <span><?php echo $myorders["product_name"]; ?></span></h5>
        <h5>Product Price: <span><?php echo $myorders["product_price"]; ?></span></h5>
        <h5>Order Quantity: <span><?php echo $myorders["product_quantity"]; ?></span></h5>
        <h5>Total Price: <span><?php echo $myorders["total_price"]; ?></span></h5>
        <h5>Order Status: <span><?php echo $myorders["order_status"]; ?></span></h5>
        <h5>Order Date: <span><?php echo $myorders["order_date"]; ?></span></h5>
        <form action="userprocess.php" method="post" class="dash-form final_form">
          <input type="hidden" name="orderid" id="on" value="<?php echo $myorders["order_id"]; ?>">
          <input type="hidden" name="productname" id="pn" value="<?php echo $myorders["product_name"]; ?>">
          <input type="hidden" name="productprice" id="pp" value="<?php echo $myorders["product_price"]; ?>">
          <input type="hidden" name="productqty" id="pp" value="<?php echo $myorders["product_quantity"]; ?>">
          <input type="submit" name="delete_order" value="Delete Order" class="mybtn logout-btn">
        </form>
        <a href="usereditorder.php?order_id=<?php echo $myorders['order_id']; ?>&user_id=<?php echo $myorders["user_id"]; ?>" class="mybtn skip-btn">Edit Order</a>
      <?php
      }
      ?>
      <form action="userprocess.php" method="post" class="dash-form final_form">
        <a href="index.php" class="mybtn skip-btn">Continue Shopping</a>
        <input type="submit" name="pay_now" value="Pay Now" class="mybtn skip-btn">
      </form>

      <form action="logout.php" method="post" class="dash-form">
        <input type="submit" value="Logout" class="mybtn logout-btn">
      </form>
    </div>

  </div>

  <?php require_once __DIR__ . "/footer.php"  ?>
  <script src="script.js"></script>

</body>


</html>
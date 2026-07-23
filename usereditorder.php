<?php
session_start();
require_once __DIR__ . "/connect.php";
//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: loginpage.php");
  exit;
}
//$id = $_SESSION['id'];
// ensure product id is passed
if (!isset($_GET['user_id'])) {
  echo "you are not logged in";
  exit;
}
$userid = $_GET['user_id'];
// echo $userid;
if (!isset($_GET['order_id'])) {
  echo "you did not choose any order";
  exit;
}

$currentproductId = $_GET['order_id'];
// echo $currentproductId;
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

      <div class="profile-box">
        <?php
        // fetch only the selected product
        $sql = "SELECT * FROM morgan_cart WHERE order_id = ? AND user_id =?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
          $_SESSION['error'] = "Failed prepare statement";
          header("Location: usereditorder.php");
          exit;
        }

        mysqli_stmt_bind_param($stmt, "ii", $currentproductId, $userid);
        mysqli_stmt_execute($stmt);
        $order = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($order) === 0) {
          echo "Product not found";
          exit;
        }

        $myorders = mysqli_fetch_assoc($order);
        // print_r($myorders);
        ?>

        <form action="userorderupdate.php" method="post" enctype="multipart/form-data" class="dash-form final_form">

          <input type="hidden" name="orderId" value="<?php echo $myorders['order_id']; ?>">

          <input type="text" name="productName" id="pn" value="<?php echo $myorders['product_name']; ?>">
          <br><br>

          <input type="text" name="productPrice" id="pp" value="<?php echo $myorders['product_price']; ?>">
          <br><br>

          <input type="text" name="productQty" id="pq" value="<?php echo $myorders['product_quantity']; ?>">
          <br><br>


          <input type="submit" name="edit_order" value="Edit Order" class="mybtn skip-btn">

        </form>

        <form action="logout.php" method="post" class="dash-form">
          <input type="submit" value="Logout" class="mybtn logout-btn">
        </form>
      </div>

    </div>
  </div>
  <?php require_once __DIR__ . "/footer.php"  ?>
  <script src="script.js"></script>



</body>


</html>
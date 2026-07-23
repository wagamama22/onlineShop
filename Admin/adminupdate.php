<?php
session_start();
require_once __DIR__ . "/../connect.php";
//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: ../loginpage.php");
  exit;
}
//$id = $_SESSION['id'];
// ensure product id is passed
if (!isset($_GET['id'])) {
  echo "No product selected";
  exit;
}

$currentproductId = $_GET['id'];
//echo $currentproductId;
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once __DIR__ . "/adminheader.php"  ?>

<body>
  <?php require_once __DIR__ . "/admin_navbar.php"  ?>

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
        $sql = "SELECT * FROM morgan_product WHERE pid = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
          $_SESSION['error'] = "Error in Sql Prepare Statement";
          header("Location: adminupdate.php");
          exit;
        }

        mysqli_stmt_bind_param($stmt, "i", $currentproductId);
        mysqli_stmt_execute($stmt);
        $product = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($product) === 0) {
          $_SESSION['error'] = "No Product Found";
          header("Location: adminupdate.php");
          exit;
        }

        $myproduct = mysqli_fetch_assoc($product);
        ?>

        <form action="adminproductedit.php" method="post" enctype="multipart/form-data" class="dash-form final_form">

          <input type="hidden" name="productId" value="<?php echo $currentproductId; ?>">

          <input type="text" name="productName" id="pn" value="<?php echo $myproduct['product_name']; ?>">
          <br><br>

          <input type="text" name="productPrice" id="pp" value="<?php echo $myproduct['product_price']; ?>">
          <br><br>

          <input type="text" name="productQty" id="pq" value="<?php echo $myproduct['product_quantity']; ?>">
          <br><br>

          <input type="file" name="myfile" id="fl" class="file-input" value="<?php echo $myproduct['product_image']; ?>">
          <br><br>

          <input type="submit" name="edit_product" value="Edit Product" class="mybtn skip-btn">

        </form>

        <form action="../logout.php" method="post" class="dash-form">
          <a href="adminproductview.php" class="mybtn skip-btn">View Product</a>
          <input type="submit" value="Logout" class="mybtn logout-btn">
        </form>
      </div>

    </div>
  </div>
  <?php require_once __DIR__ . "/../footer.php"  ?>
  <script src="script.js"></script>



</body>


</html>
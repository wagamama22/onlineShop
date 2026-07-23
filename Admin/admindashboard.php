<?php
session_start();
if (!@include("../connect.php")) {
  echo "dataase connection not enabled";
}
//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: ../loginpage.php");
  exit;
}
//$id = $_SESSION['id'];
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

      <form action="uploadproduct.php" method="post" enctype="multipart/form-data" class="dash-form final_form">
        <input type="text" name="productName" id="pn" placeholder="Product Name">
        <br><br>
        <input type="text" name="productPrice" id="pp" placeholder="Product Price">
        <br><br>
        <input type="text" name="productQty" id="pq" placeholder="Product Quantity">
        <br><br>
        <input type="file" name="myfile" id="fl" class="file-input">
        <input type="submit" name="add_product" value="Add Product" class="mybtn skip-btn">
      </form>

      <form action="../logout.php" method="post" class="dash-form">
        <a href="adminproductview.php" class="mybtn skip-btn">View Product</a>
        <input type="submit" value="Logout" class="mybtn logout-btn">
      </form>
    </div>

  </div>

  <?php require_once __DIR__ . "/../footer.php"  ?>
  <script src="script.js"></script>

</body>


</html>
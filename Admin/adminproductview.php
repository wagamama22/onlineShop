<?php
session_start();
require_once __DIR__ . "/../connect.php";
//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: ../loginpage.php");
  exit;
}
$id = $_SESSION['id'];
// echo $id;
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once __DIR__ . "/adminheader.php"  ?>

<body>
  <?php require_once __DIR__ . "/admin_navbar.php"  ?>

  <div class="container mt-4">
    <!-- write php code to access all the products in the dataase -->
    <!-- create the which must house the columns to avoid reaking the grid -->
    <?php if (isset($_SESSION["success"])): ?>
      <div class=" display_index_success_cart alert alert<?php echo $_SESSION["success"]; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION["success"];
        unset($_SESSION['success']); ?>
        <button type="button" class="btn-close " data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if (isset($_SESSION["error"])): ?>
      <div class=" display_index_success_cart alert alert<?php echo $_SESSION["success"]; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION["error"];
        unset($_SESSION['error']); ?>
        <button type="button" class="btn-close " data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <div class="row">
      <?php
      $sql = "SELECT * FROM morgan_product";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "Error in sql prepare statement";
        header("Location: adminproductview.php");
        exit;
      }
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) === 0) {
        $_SESSION['error'] = "No Product Found";
        header("Location: adminproductview.php");
        exit;
      }
      while ($products = mysqli_fetch_assoc($result)) {
        //print_r($products);
      ?>
        <div class="col-sm-6 col-md-4 mb-4">
          <div class="card">
            <div class="dimage">
              <img src="../images/<?php echo $products['product_image']; ?>" class="img-fluid">
            </div>
            <div class="card-body">
              <h5 class="card-title text-primary dinputs"><?php echo $products['product_name']; ?></h5>

              <p class="dinputs d-flex flex-column">
                <span>
                  <span class="text-dark fw-bold">Price:</span>
                  <span class="text-success fw-bold"><?php echo "€" . $products['product_price']; ?></span>
                </span>

                <span>
                  <span class="text-dark fw-bold">Quantity:</span>
                  <span class="text-success fw-bold"><?php echo $products['product_quantity']; ?></span>
                </span>
              </p>
              <form action="deleteadminproduct.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="pid" value="<?php echo $products['pid']; ?>">
                <input type="hidden" name="productName" value="<?php echo $products['product_name']; ?>">
                <p class="dbutton">
                  <a href="adminupdate.php?id=<?php echo $products['pid']; ?>" class="btn btn-primary">Edit</a>
                  <input type="submit" value="Delete" class="btn btn-danger">
                </p>
              </form>


            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>




  </div>

  <?php require_once __DIR__ . "/../footer.php"  ?>
  <script src="script.js"></script>

</body>


</html>
<?php
session_start();
require_once __DIR__ . "/connect.php";
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
  // echo $id;
}
if (isset($_SESSION["id"])) {
  require_once __DIR__ . "/myprofile.php";
}

// echo $id;
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once __DIR__ . "/generalheader.php"  ?>

<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark header">
    <div class="container container-fluid ">
      <img src="images/logo.png" class="navbar-brand header__logo" alt="logo" id="logo"><a id="logo-anch" class="navbar-brand" href="#"><strong>Morgan Limited</strong></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mNavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" href="/shopping_cart/index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/shopping_cart/signup.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/shopping_cart/loginpage.php">Login</a>
          </li>
        </ul>
        <?php if (isset($_SESSION['id'])): ?>
          <div class="nav_profile">
            <img class="profile-imgnav" src="images/<?php echo $profileimg === 'default.png' ? 'default.png' : $profileimg; ?>" alt="Profile">
            <span class="mythumbnail"><?php echo $name ?></span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </nav>

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
        $_SESSION['error'] = "Error in Sql prepare statement";
        header("Location: index.php");
        exit;
      }
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) === 0) {
        $_SESSION['error'] = "No products found";
        header("Location: index.php");
        exit;
      }
      while ($products = mysqli_fetch_assoc($result)) {
        //print_r($products);
      ?>
        <div class="col-sm-6 col-md-4 mb-4">
          <div class="card">
            <div class="dimage">
              <img src="images/<?php echo $products['product_image']; ?>" class="img-fluid">
            </div>
            <div class="card-body">
              <h5 class="card-title text-primary dinputs"><?php echo $products['product_name']; ?></h5>
              <form action="addtocart.php" method="post" enctype="multipart/form-data">
                <div class="priceqty-wrapper">
                  <p class="dinputs_indexprice final_indexform">
                    <span>
                      <span class="text-dark fw-bold">Price:</span>
                      <span class="text-success fw-bold">€<?php echo $products['product_price']; ?></span>
                    </span>
                    <br>
                    <span>
                      <span class="text-dark fw-bold">Quantity:</span>
                      <input type="text" name="productquantity" id="pq" value="1" class="text-success fw-bold">
                    </span>
                  </p>
                </div>

                <input type="hidden" name="pid" value="<?php echo $products['pid']; ?>">
                <input type="hidden" name="productName" value="<?php echo $products['product_name']; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $products['product_price']; ?>">
                <input type="hidden" name="order_status" value="pending">
                <p class="dbutton">
                  <input type="submit" name="AddToCart" value="Add To Cart" class="btn btn-success fw-bold">
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

  <?php require_once __DIR__ . "/footer.php"  ?>
  <script src="script.js"></script>

</body>


</html>
<?php
session_start();
require_once __DIR__ . "/../connect.php";

// ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: ../loginpage.php");
  exit;
}

if (!isset($_POST['edit_product'])) {
  $_SESSION['error'] = "Invalid request";
  header("Location: adminproductview.php");
  exit;
}

// GET POST VALUES
$currentproductname = $_POST['productName'];
$currentproductprice = $_POST['productPrice'];
$currentproductqty = $_POST['productQty'];
$currentproductid = $_POST['productId'];

// VALIDATION
if (empty($currentproductname) || empty($currentproductprice) || empty($currentproductqty)) {
  $_SESSION['error'] = "Input text fields cannot be empty";
  header("Location: adminupdate.php?id=" . $currentproductid);
  exit;
}

if (!ctype_digit($currentproductqty)) {
  $_SESSION['error'] = "Quantity must be a number";
  header("Location: adminupdate.php?id=" . $currentproductid);
  exit;
}

// FILE HANDLING
$file_name = $_FILES["myfile"]["name"];
$filetmpname = $_FILES["myfile"]["tmp_name"];
$filesize = $_FILES["myfile"]['size'];

$allowedFile = array('jpeg', 'jpg', 'png');

// CASE 1: USER UPLOADED A NEW FILE
if (!empty($file_name)) {

  $fileext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

  if (!in_array($fileext, $allowedFile)) {
    $_SESSION['error'] = "Invalid file type";
    header("Location: adminupdate.php?id=" . $currentproductid);
    exit;
  }

  if ($filesize > 1000000) {
    $_SESSION['error'] = "File size too large";
    header("Location: adminupdate.php?id=" . $currentproductid);
    exit;
  }

  $newFileDest = "../images/" . $file_name;
  move_uploaded_file($filetmpname, $newFileDest);

  $imageToSave = $file_name;
} else {
  // CASE 2: USER DID NOT UPLOAD A NEW FILE → KEEP OLD IMAGE
  $sqlImg = "SELECT product_image FROM morgan_product WHERE pid = ?";
  $stmtImg = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmtImg, $sqlImg);
  mysqli_stmt_bind_param($stmtImg, "i", $currentproductid);
  mysqli_stmt_execute($stmtImg);
  $resultImg = mysqli_stmt_get_result($stmtImg);
  $rowImg = mysqli_fetch_assoc($resultImg);

  $imageToSave = $rowImg['product_image'];
}

// UPDATE PRODUCT
$sql = "UPDATE morgan_product 
        SET product_name=?, product_price=?, product_quantity=?, product_image=? 
        WHERE pid = ?";

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $currentproductname, $currentproductprice, $currentproductqty, $imageToSave, $currentproductid);
mysqli_stmt_execute($stmt);

$_SESSION['success'] = "You have updated {$currentproductname} successfully";
header("Location: adminproductview.php");
exit;

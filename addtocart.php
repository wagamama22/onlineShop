<?php
session_start();
require_once __DIR__ . "/connect.php";
//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: loginpage.php");
  exit;
}

// echo $userid;
if (isset($_POST["AddToCart"])) {
  //getting userinputs safely
  $productid = mysqli_real_escape_string($conn, $_POST["pid"]);
  // echo $productid;
  $productname = mysqli_real_escape_string($conn, $_POST["productName"]);
  // echo $productname;
  $productprice = mysqli_real_escape_string($conn, $_POST["productPrice"]);
  // echo $productprice;
  $productqty = mysqli_real_escape_string($conn, $_POST["productquantity"]);
  // echo $productqty;
  $userid = $_SESSION['id'];
  $statusorder = mysqli_real_escape_string($conn, $_POST["order_status"]);
  // echo "order status: {$statusorder}";
  $grandtotal = $productqty * $productprice;
  // echo $grandtotal;

  //start sql statement and submit data to margan_cart table
  $sql = "INSERT  INTO morgan_cart(user_id,product_name,product_price,product_quantity,total_price,order_status) VALUES (?,?,?,?,?,?) ";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "isdids", $userid, $productname, $productprice, $productqty, $grandtotal, $statusorder);
  mysqli_stmt_execute($stmt);
  $_SESSION["success"] = "order was added to cart successfully";
  header("Location: pendingorders.php");
  exit;
}

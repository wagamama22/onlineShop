<?php
session_start();
require_once __DIR__ . "/connect.php";
//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: loginpage.php");
  exit;
}
$userid = $_SESSION['id'];
//echo $userid;

//getting userinputs safely

if (isset($_POST["edit_order"])) {
  $orderid = mysqli_real_escape_string($conn, $_POST['orderId']);
  $editorderdate = date("Y-m-d H:i:s");
  $productname = mysqli_real_escape_string($conn, $_POST["productName"]);
  $productprice = mysqli_real_escape_string($conn, $_POST["productPrice"]);
  $productqty = mysqli_real_escape_string($conn, $_POST["productQty"]);
  $totalprice = $productqty * $productprice;

  $sqledit = "UPDATE morgan_cart 
                SET order_status='pending',
                    order_date=?,
                    product_name=?,
                    product_price=?,
                    product_quantity=?,
                    total_price=?
                WHERE user_id=? AND order_id=?";

  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sqledit);

  mysqli_stmt_bind_param(
    $stmt,
    "ssdidii",
    $editorderdate,
    $productname,
    $productprice,
    $productqty,
    $totalprice,
    $userid,
    $orderid
  );

  mysqli_stmt_execute($stmt);

  $_SESSION["success"] = "You have successfully updated your order";
  header("Location: pendingorders.php");
  exit;
}

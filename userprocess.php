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

if (isset($_POST["pay_now"])) {
  $orderdate = date("Y-m-d H:i:s");
  $sqlupdate = "UPDATE morgan_cart SET order_status='paid',order_date=? WHERE user_id=?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sqlupdate);
  mysqli_stmt_bind_param($stmt, "si", $orderdate, $userid);
  mysqli_stmt_execute($stmt);
  $_SESSION["success"] = "Payment Completed successfully";
  header("Location: paidorders.php");
  exit;
} else if (isset($_POST["delete_order"])) {
  $orderid = mysqli_real_escape_string($conn, $_POST["orderid"]);
  $sqldelete = "DELETE FROM morgan_cart WHERE order_id=? ";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sqldelete);
  mysqli_stmt_bind_param($stmt, "i", $orderid);
  mysqli_stmt_execute($stmt);
  $_SESSION["success"] = "Order deleted successfully";
  header("Location: pendingorders.php");
  exit;
}

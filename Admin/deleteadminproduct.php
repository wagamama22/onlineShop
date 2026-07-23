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
$currentproductid = mysqli_real_escape_string($conn, $_POST["pid"]);
$currentproductname = mysqli_real_escape_string($conn, $_POST["productName"]);
//sql delete need only one parameter

$sql = "DELETE FROM morgan_product WHERE pid = ?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "s",  $currentproductid);
mysqli_stmt_execute($stmt);
$_SESSION['success'] = "{$currentproductname} deleted successfully";
header("Location: adminproductview.php");
exit;

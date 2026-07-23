<?php
session_start();
require_once __DIR__ . "/../connect.php";
//var_dump($conn); //check if con works
$id = $_SESSION['id'];
//ensure user is signed in
if (!isset($_SESSION['id'])) {
  header("Location: ../loginpage.php");
  exit;
}

//grab userinputs from form textfields
$pname = mysqli_real_escape_string($conn, $_POST["productName"]);
$pprice = mysqli_real_escape_string($conn, $_POST["productPrice"]);
$pqty = mysqli_real_escape_string($conn, $_POST["productQty"]);
$file_name = $_FILES["myfile"]["name"];
$fileType = $_FILES["myfile"]['type'];
$filetmpname = $_FILES["myfile"]["tmp_name"];
$filesize = $_FILES["myfile"]['size'];
$fileFullPath = explode('.', $file_name);
$fileext = strtolower(end($fileFullPath));
$allowedFile = array('jpeg', 'jpg', 'png');
$newFileLDest = "../images/" . $file_name;

//userinput validation
if (empty($pname) || empty($pprice) || empty($pqty)) {
  $_SESSION['error'] = "input text fields cannot be empty";
  header("Location: admindashboard.php");
  exit;
}
if (!ctype_digit($pqty)) {
  $_SESSION['error'] = "Quantity field must not be letters";
  header("Location: admindashboard.php");
  exit;
}
if (empty($file_name)) {
  $_SESSION['error'] = "you need to add picture file";
  header("Location: admindashboard.php");
  exit;
}
if (!in_array($fileext, $allowedFile)) {
  $_SESSION['error'] = "you cannot upload this type of file";
  header("Location: admindashboard.php");
  exit;
}
if ($filesize > 1000000) {
  $_SESSION['error'] = "File size limit is exceeded";
  header("Location: admindashboard.php");
  exit;
}

//start inserting into product tale
$sql = "INSERT INTO morgan_product (product_name, product_price, product_quantity, product_image) VALUES (?,?,?,?)";
//initialise prepare statement
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
  move_uploaded_file($filetmpname, $newFileLDest);
  mysqli_stmt_bind_param($stmt, "ssss", $pname, $pprice, $pqty, $file_name);
  mysqli_stmt_execute($stmt);
} else {
  die("SQL error: " . mysqli_error($conn));
}
$_SESSION["success"] = "product added sucessfully {$id}";
header("Location: admindashboard.php");
exit;

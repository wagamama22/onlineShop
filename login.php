<?php
session_start();
if (!@include("connect.php")) {
  $_SESSION['error'] = "dataase connection not enabled";
  header("Location: loginpage.php");
  exit;
}

//collect user form inputs
$email_phone = mysqli_real_escape_string($conn, $_POST['emailphone']);
$s_key = mysqli_real_escape_string($conn, $_POST['skey']);
if (empty($email_phone) || empty($s_key)) {
  $_SESSION['error'] = "Input textfields cannot be left empty";
  header("Location: loginpage.php");
  exit;
}


//assign value to placeholder
$data6 = $email_phone;
$data7 = $s_key;

$sql = "SELECT * FROM morgan_user WHERE email = ? or phone_number=? ";
//connect and initialise prepared stmt
$stmt = mysqli_stmt_init($conn);
//check if prepared stmt is properly connected to dataase
if (!mysqli_stmt_prepare($stmt, $sql)) {
  $_SESSION['error'] = "sql prepare stmt did not connect with database";
  header("Location: loginpage.php");
} else {
  //bind stmt with parameters
  mysqli_stmt_bind_param($stmt, 'ss', $data6, $data6);
  //execute prepared stmt on database
  mysqli_stmt_execute($stmt);
  //get the result of prepared stmt executed on database 
  $result = mysqli_stmt_get_result($stmt);
  //check if data exist in dataase
  if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($data7, $row['secret_key'])) {
      $_SESSION['userinput'] = $row['email'] ?: $row['phone_number'];
      $_SESSION['login_id'] = $row['secret_key'];
      $_SESSION['user_type'] = $row['role'];
      $_SESSION['id'] = $row['id'];
      $_SESSION['profileimg'] = $row['profile_img'];
      $_SESSION['name'] = $row['first_name'];
      $_SESSION['surname'] = $row['last_name'];
      if ($_SESSION['user_type'] === "user") {
        $_SESSION['success'] = "You have logged in successfully";
        header("Location: userupload.php");
        exit;
      } else {
        $_SESSION['success'] = "You have logged in successfully";
        header("Location: ./Admin/admindashboard.php");
        exit;
      }
    } else {
      $_SESSION['error'] = "Your password is incorrect. Try again";
      header("Location: loginpage.php");
      exit;
    }
  } else {
    $_SESSION['error'] = "invalid email or phone number. You are yet to signup";
    header("Location: loginpage.php");
    exit;
  }
}

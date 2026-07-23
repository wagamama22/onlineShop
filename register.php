<?php
session_start();
if (!@include("connect.php")) {
  echo "dataase connection not enabled";
}

$f_name = mysqli_real_escape_string($conn, $_POST['fname']);
$l_name = mysqli_real_escape_string($conn, $_POST['lname']);
$u_email = mysqli_real_escape_string($conn, $_POST['email']);
$p_number = mysqli_real_escape_string($conn, $_POST['pnumber']);
$p_role = mysqli_real_escape_string($conn, $_POST['role']);
$s_key = mysqli_real_escape_string($conn, $_POST['skey']);

//validate
if (empty($f_name) || empty($l_name) || empty($u_email) || empty($p_number) || empty($p_role) || empty($s_key)) {
  $_SESSION['error'] = "Input textfields cannot be left empty";
  header("Location: signup.php");
  exit;
}
if (!filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['error'] = "Please enter a valid email address";
  header("Location: signup.php");
  exit;
}
if (!ctype_alpha($f_name) || !ctype_alpha($l_name)) {
  $_SESSION['error'] = "name and surname cannot contain a digit";
  header("Location: signup.php");
  exit;
}
if (strlen($s_key) < 5) {
  $_SESSION['error'] = "Password must have a minimum of 5 numbers ";
  header("Location: signup.php");
  exit;
}
if (!ctype_digit($p_number) || strlen($p_number) > 8) {
  $_SESSION['error'] = "Phone number must contain only digits and must not exceed 8 numbers";
  header("Location: signup.php");
  exit;
}

$data = $f_name;
$data1 = $l_name;
$data2 = $u_email;
$data3 = $p_number;
$data4 = $p_role;
$data5 = password_hash($s_key, PASSWORD_DEFAULT);

//check if email or phone numer exist before adding to database
$check_sql = "SELECT email, phone_number FROM morgan_user WHERE email = ? OR phone_number = ?";
$check_stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($check_stmt, $check_sql);
mysqli_stmt_bind_param($check_stmt, "ss", $u_email, $p_number);
mysqli_stmt_execute($check_stmt);
$result = mysqli_stmt_get_result($check_stmt);

if ($row = mysqli_fetch_assoc($result)) {

  if ($row['email'] === $u_email) {
    $_SESSION['error'] = "Email already exists. Please use another email.";
    header("Location: signup.php");
    exit;
  }
  if ($row['phone_number'] === $p_number) {
    $_SESSION['error'] = "Phone number already exists. Please use another number.";
    header("Location: signup.php");
    exit;
  }
}

$sql = "INSERT INTO morgan_user(first_name, last_name, email, phone_number , role, secret_key) VALUES(?,?,?,?,?,?)";
//initialise stmt at conn connection
$stmt = mysqli_stmt_init($conn);
//create the prepare stmt and pass it on to a variable
$chk = mysqli_stmt_prepare($stmt, $sql);
//check if the prepare statement is ok and seen by database
if (!$chk) {
  $_SESSION['error'] = "mysqli prepare is in error";
  header("Location: signup.php");
  exit;
} else {
  //bind the stmt with the placeholder information
  mysqli_stmt_bind_param($stmt, 'ssssss', $data, $data1, $data2, $data3, $data4, $data5);
  //execute by inserting data inside the database
  mysqli_stmt_execute($stmt);
  $_SESSION['error'] = "{$f_name} is has signed up successfully. Login now}";
  header("Location: loginpage.php");
  exit;
}

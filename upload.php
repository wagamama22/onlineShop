<?php
session_start();

if (!@include("connect.php")) {
  echo "dataase connection not enabled <br>";
}
if (!isset($_SESSION['id'])) {
  header("Location: loginpage.php");
  exit;
}

$id = $_SESSION['id'];
echo "user id: {$id}";

if (isset($_POST['submitfile'])) {
  $userInputFile = $_FILES['myfile'];
  //print_r($userInputFile);
  //start accessing the file
  $filename = $userInputFile['name'];
  //print_r($fileext);
  $fileType = $userInputFile['type'];
  $fileTemplocation = $userInputFile['tmp_name'];
  $filesize = $userInputFile['size'];
  $fileerror = $userInputFile['error'];
  $fileFullPath = explode('.', $filename);
  //print_r($fileresult);
  $fileext = strtolower($fileFullPath[1]);
  $allowedFile = array('jpeg', 'jpg', 'png');
  //check if file type is allowed
  if (!in_array($fileext, $allowedFile)) {
    echo "you cannot upload that type of file";
    exit;
  }

  if (!$fileerror === 0) {
    echo "error un file upload. You have not uploaded any file";
    exit;
  }

  if ($filesize > 1000000) {
    echo "the file size is too big to upload";
    exit;
  }

  //newfilename = userid.filext
  $filenewName = "profile" . $id . '.' . $fileext;
  $newFileLocation = "images/" . $filenewName;
  move_uploaded_file($fileTemplocation, $newFileLocation);
  //update the profile image and user id in the database
  $sqlupdate = "UPDATE morgan_user SET profile_img = ? WHERE id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sqlupdate)) {
    echo "SQL error in update statement";
    exit;
  }
  mysqli_stmt_bind_param($stmt, 'ss', $filenewName, $id);
  mysqli_stmt_execute($stmt);
  //update profile session
  $_SESSION['profileimg'] = $filenewName;
  header("Location: userupload.php");
  exit;

  //if file upload is without error

} else {
  echo "you have not clicked upload button";
}

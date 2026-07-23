<?php
session_start();
if (!@include("connect.php")) {
  echo "database connection not enabled <br>";
}

if (!isset($_SESSION['id'])) {
  header("Location: loginpage.php");
  exit;
}

if (isset($_SESSION['success'])) {
  echo "<div class='success_msg'>" . $_SESSION['success'] . "</div>";
  unset($_SESSION['success']);
}

$id = $_SESSION['id'];
// $name = $_SESSION['name'];
$surname = $_SESSION['surname'];
// $profileimg = $_SESSION['profileimg'];
require_once __DIR__ . "/myprofile.php";
?>


<!DOCTYPE html>
<html lang="en">

<?php require_once __DIR__ . "/generalheader.php"  ?>

<body>
  <?php require_once __DIR__ . "/userdashboard_navbar.php"  ?>

  <div class="dashboard-wrapper">

    <div class="profile-box">
      <div class="profile-img">
        <img src="images/<?php echo $profileimg === 'default.png' ? 'default.png' : $profileimg; ?>" alt="Profile">
      </div>

      <h2 class="profile-name">
        <?php echo $name . " " . $surname; ?>
      </h2>

      <form action="upload.php" method="post" enctype="multipart/form-data" class="dash-form">
        <input type="file" name="myfile" id="fl" class="file-input">
        <input type="submit" name="submitfile" value="Upload" class="mybtn">
      </form>

      <form action="logout.php" method="post" class="dash-form">
        <a href="userdashboard.php" class="mybtn skip-btn">Skip</a>
        <input type="submit" value="Logout" class="mybtn logout-btn">
      </form>
    </div>

  </div>

  <?php require_once __DIR__ . "/footer.php"  ?>
  <script src="script.js"></script>

</body>


</html>
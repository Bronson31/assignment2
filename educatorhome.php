<form action= "" method="post">
  <input type="submit" name="logout" value="logout">
</form>
<?php
session_start();
echo "Logged in as " . $_SESSION['username'];
?>
<title> Home Page</title>
<h1>Educator Home Page</h1></br>
<?php

if (!isset($_SESSION['username']) || !$_SESSION['username']) {
  header("Location: index.php");
  exit;
}

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: index.php");
  exit;
}

if (isset($_POST['student'])) {
  header("Location: student.php");
  exit;
}

if (isset($_POST['teachingsubject'])) {
  header("Location: teachingsubject.php");
  exit;
}

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // use $username to fetch the data from the administrator table
    $conn = mysqli_connect("localhost", "root", "", "online_enrollment");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
}

$query = "SELECT * FROM educator WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
  $educator = mysqli_fetch_assoc($result);
  echo "Staff ID: " . $educator['staff_id'] . "<br>";
  echo "Name: " . $educator['name'] . "<br>";
  echo "Phone: " . $educator['phone'] . "<br>";
  echo "Email: " . $educator['email'] . "<br>";
  echo "Teaching Subjects: " . $educator['teaching_subjects'] . "<br>";
  $_SESSION['teaching_subjects'] = $educator['teaching_subjects'];
} else {
  echo "No Educator found with username '$username'";
}

mysqli_close($conn);

?>
<form method="post">
  <input type="submit" name="teachingsubject" value="Manage teaching subjects">
  <input type="submit" name="student" value="Search Students">
</form>
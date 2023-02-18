<form action= "" method="post">
  <input type="submit" name="logout" value="logout">
</form>
<?php
session_start();
echo "Logged in as " . $_SESSION['username'];
?>
<title> Home Page</title>
<h1>Student Home Page</h1></br>

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

if (isset($_POST['enrollsubject'])) {
  header("Location: enrollsubject.php");
  exit;
}

if (isset($_POST['subjectinformation'])) {
  header("Location: subjectinformation.php");
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

$query = "SELECT * FROM student WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
  $student = mysqli_fetch_assoc($result);
  echo "Student ID: " . $student['student_id'] . "<br>";
  echo "Name: " . $student['name'] . "<br>";
  echo "Phone: " . $student['phone'] . "<br>";
  echo "Email: " . $student['email'] . "<br>";
  echo "Enrolled Subjects: " . $student['enrolled_subjects'] . "<br>";
} else {
  echo "No Student found with username '$username'";
}

mysqli_close($conn);

?>
<form method="post">
  <input type="submit" name="enrollsubject" value="Manage Enrollment">
  <input type="submit" name="subjectinformation" value="Subject Information">
</form>
<html>
  <body>
<form action= "" method="post">
  <input type="submit" name="logout" value="logout">
</form>
<title> Home Page</title>
<h1>Admin Home Page</h1></br>
<?php
session_start();

if (!isset($_SESSION['username']) || !$_SESSION['username']) {
  header("Location: index.php");
  exit;
}

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: index.php");
  exit;
}

if (isset($_POST['insert_subjects'])) {
  header("Location: insert_subjects.php");
  exit;
}

if (isset($_POST['subject'])) {
  header("Location: subject.php");
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

$query = "SELECT * FROM administrator WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
  $administrator = mysqli_fetch_assoc($result);
  echo "Staff ID: " . $administrator['admin_id'] . "<br>";
  echo "Name: " . $administrator['name'] . "<br>";
  echo "Phone: " . $administrator['phone'] . "<br>";
  echo "Email: " . $administrator['email'] . "<br>";
  echo "Position: " . $administrator['position'] . "<br>";
} else {
  echo "No administrator found with username '$username'";
}

mysqli_close($conn);

?>

<form method="post">
  <input type="submit" name="insert_subjects" value="Insert Subjects">
  <input type="submit" name="subject" value="Manage Subjects">
</form>
</body>
</html>

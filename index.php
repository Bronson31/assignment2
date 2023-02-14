<?php
if (isset($_POST['register'])) {
  header("Location: register.php");
  exit;
}

session_start();

if (array_key_exists('username', $_SESSION)) {
  if (array_key_exists('rid', $_SESSION) && $_SESSION['rid'] == 1) {
    header("Location: adminhome.php");
    exit;
  }

  if (array_key_exists('rid', $_SESSION) && $_SESSION['rid'] == 2) {
    header("Location: educatorhome.php");
    exit;
  }

  if (array_key_exists('rid', $_SESSION) && $_SESSION['rid'] == 3) {
    header("Location: studenthome.php");
    exit;
  }
}

$username = '';
$password = '';
$error = '';



if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $conn = mysqli_connect("localhost", "root", "", "online_enrollment");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $user['username'];
    if (array_key_exists('rid', $user)) {
        $_SESSION['rid'] = $user['rid'];
    }
} else {
    $error = 'Incorrect username or password';
}

if (array_key_exists('rid', $_SESSION) && $_SESSION['rid'] == 1) {
    header("Location: adminhome.php");
    exit;
}

if (array_key_exists('rid', $_SESSION) && $_SESSION['rid'] == 2) {
    header("Location: educatorhome.php");
    exit;
}

if (array_key_exists('rid', $_SESSION) && $_SESSION['rid'] == 3) {
    header("Location: studenthome.php");
    exit;
}

mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <style>
    .error {
      color: red;
    }
  </style>
</head>
<body>
<h1> Online Subject Enrollment System</h1>
  <h2>Login</h2>
  <form action="" method="post">
    <div>
      <label for="username">Username:</label>
      <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter username" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input type="password" name="password" placeholder="Enter password" required>
    </div>
    <div>
      <input type="submit" name="submit" value="Login">
    </div>
  </form>
  <div class="error">
    <?php echo $error; ?>
  </div>

  <form action="" method="post">
    <input type="submit" name="register" value="Register Account">
  </form>
</body>
</html>

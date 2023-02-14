<?php
if (isset($_POST['login'])) {
    header("Location: index.php");
    exit;
  }
  

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_enrollment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $rid = $_POST['rid'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO user (username, password, email, rid)
    VALUES ('$username', '$password', '$email', '$rid')";
    if ($conn->query($sql) === TRUE) {
        echo "Registered successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($rid == 1) {
        $position = "newbie";
        $sql = "INSERT INTO administrator (username, name, phone, email, position)
        VALUES ('$username', '$name', '$phone', '$email', '$position')";
        if ($conn->query($sql) === TRUE) {
            echo "Registered as Adminstrator";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if ($rid == 2) {
        $teaching_subjects = "";
        $sql = "INSERT INTO educator (username, name, phone, email, teaching_subjects)
        VALUES ('$username', '$name', '$phone', '$email', '$teaching_subjects')";
        if ($conn->query($sql) === TRUE) {
            echo "Registered as Educator";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if ($rid == 3) {
        $enrolled_subjects = "";
        $student_status = "active";
        $sql = "INSERT INTO student (username, name, phone, email, enrolled_subjects, student_status)
        VALUES ('$username', '$name', '$phone', '$email', '$enrolled_subjects', '$student_status')";
        if ($conn->query($sql) === TRUE) {
            echo "Registered as Student";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


}

$conn->close();
?>

<html>
<form action="" method="post">
    <input type="submit" name="login" value="Go to Login Page">
</form>
<head>
    <title>Registration</title>
</head>
<body>
    <h1>Register</h1>
    <form method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="phone">Phone:</label><br>
        <input type="number" id="phone" name="phone" required><br>
        <label for="rid">Role:</label><br>
        <select id="rid" name="rid">
            <option value="1">Administrator</option>
            <option value="2">Educator</option>
            <option value="3">Student</option>
        </select><br><br>
        <input type="submit" value="Submit" name="submit">
    </form> 
</body>
</html>

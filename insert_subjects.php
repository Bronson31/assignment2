<!DOCTYPE html>
<html>
<form method="post">
<input type="submit" name="adminhome" value="Admin Home">
</form><br>
<head>
  <title>Insert Subjects</title>
</head>
<?php
session_start();
echo "Logged in as " . $_SESSION['username'];
?>
<body>
<h1>Insert Subjects</h1>
	<form action="insert_subjects.php" method="post">
		<label for="subject_name">Subject Name:</label>
		<input type="text" id="subject_name" name="subject_name">
		<br><br>

		<label for="subject_code">Subject Code:</label>
		<input type="text" id="subject_code" name="subject_code">
		<br><br>

		<label for="venue">Venue:</label>
		<input type="text" id="venue" name="venue">
		<br><br>

    <label for="subject_status">Subject Status:</label>
    <select name="subject_status" id="subject_status">
    <option value="active">active</option>
    <option value="inactive">inactive</option>
    <option value="removed">removed</option>
    </select>
		<br><br>

		<label for="lecture_date">Lecture Date:</label>
		<input type="date" id="lecture_date" name="lecture_date">
		<br><br>

		<label for="lecture_time">Lecture Time:</label>
		<input type="time" id="lecture_time" name="lecture_time">
		<br><br>

		<input type="submit" name="submit" value="Submit">
	</form>
	<br>

  <?php

if (isset($_POST['adminhome'])) {
  header("Location: adminhome.php");
  exit;
}

if(!isset($_SESSION["rid"]) || $_SESSION["rid"] != 1) {
  header("Location: index.php");
  exit;
}


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online_enrollment";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_POST['submit'])) {
        $subject_name = $_POST['subject_name'];
        $subject_code = $_POST['subject_code'];
        $venue = $_POST['venue'];
			  $subject_status = $_POST['subject_status'];
			  $lecture_date = $_POST['lecture_date'];
			  $lecture_time = $_POST['lecture_time'];

        $sql = "INSERT INTO subject (subject_code, name, venue, subject_status, lecture_date, lecture_time)
        VALUES ('$subject_code', '$subject_name', '$venue', '$subject_status', '$lecture_date', '$lecture_time')";

        if (mysqli_query($conn, $sql)) {
            echo "Subject inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
  ?>
</body>
</html>

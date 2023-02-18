<title>Teaching Subjects</title>
<form method="post">
<input type="submit" name="educatorhome" value="Educator Home">
</form>
<?php
session_start();
echo "Logged in as " . $_SESSION['username'];
?>
<h1> Manage Teaching Subjects </h1>
<?php

if (isset($_POST['educatorhome'])) {
    header("Location: educatorhome.php");
    exit;
  }
  
  if(!isset($_SESSION["rid"]) || $_SESSION["rid"] != 2) {
    header("Location: index.php");
    exit;
  }



?>

<h2>My teaching subjects: </h2>

<table border="1">
    <thead>
        <tr>
            <th>Subject ID</th>
            <th>Subject Code</th>
            <th>Name</th>
            <th>Venue</th>
            <th>Student Number</th>
            <th>Subject Status</th>
            <th>Lecture Date</th>
            <th>Lecture Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

<?php

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_enrollment";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$username = $_SESSION['username'];

    // Check if the user has clicked the remove button for a subject
    if (isset($_POST['not_teach'])) {
        // Get the subject to be removed
        $subject = $_POST['subject'];
    
        // Get the current list of teaching subjects for the educator
        $sql = "SELECT teaching_subjects FROM educator WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $teaching_subjects = explode(',', $row['teaching_subjects']);
    
        // Remove the subject from the list
        $new_teaching_subjects = array();
        foreach ($teaching_subjects as $teaching_subject) {
            if (trim($teaching_subject) != $subject) {
                $new_teaching_subjects[] = $teaching_subject;
            }
        }
    
        // Update the teaching_subjects field in the database for the educator
        $new_teaching_subjects_string = implode(',', $new_teaching_subjects);
        $update_sql = "UPDATE educator SET teaching_subjects = '$new_teaching_subjects_string' WHERE username = '$username'";
        mysqli_query($conn, $update_sql);
    }

// Select all data from the table "subject"
$sql = "SELECT *
FROM subject
WHERE EXISTS (
  SELECT *
  FROM educator
  WHERE username = '$username' 
  AND teaching_subjects LIKE CONCAT('%', subject.name, '%')
);";
$result = mysqli_query($conn, $sql);






// Check if there are any subjects in the table
if (mysqli_num_rows($result) > 0) {

    // Loop through all subjects and print them in the table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["subject_id"] . "</td>";
        echo "<td>" . $row["subject_code"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["venue"] . "</td>";
        echo "<td>" . $row["student_number"] . "</td>";
        echo "<td>" . $row["subject_status"] . "</td>";
        echo "<td>" . $row["lecture_date"] . "</td>";
        echo "<td>" . $row["lecture_time"] . "</td>";
        echo "<td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='subject' value='". $row["name"] ."'>";
        echo "<input type='submit' name='not_teach' value='Not Teach'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>


<br><h2> Not my teaching subjects: </h2>

<table border="1">
    <thead>
        <tr>
            <th>Subject ID</th>
            <th>Subject Code</th>
            <th>Name</th>
            <th>Venue</th>
            <th>Student Number</th>
            <th>Subject Status</th>
            <th>Lecture Date</th>
            <th>Lecture Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
<?php


// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_enrollment";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$username = $_SESSION['username'];

if (isset($_POST["teach"])) {
    $subject_id = $_POST["subject_id"];
    $username = $_SESSION['username'];

    // Check if the educator is already teaching the subject
$sql = "SELECT *
FROM educator
WHERE username = '$username' 
AND teaching_subjects LIKE CONCAT('%', (SELECT name FROM subject WHERE subject_id = '$subject_id'), '%');";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "You are already teaching this subject.";
} else 
    // Update the educator's teaching subjects
    $sql = "UPDATE educator
    SET teaching_subjects = CONCAT(teaching_subjects, ', ', (SELECT name FROM subject WHERE subject_id = '$subject_id'))
    WHERE username = '$username';";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: teachingsubject.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


}

// Select all data from the table "subject"
$sql = "SELECT *
FROM subject
WHERE NOT EXISTS (
  SELECT *
  FROM educator
  WHERE username = '$username' 
  AND teaching_subjects LIKE CONCAT('%', subject.name, '%')
);";
$result = mysqli_query($conn, $sql);




// Check if there are any subjects in the table
if (mysqli_num_rows($result) > 0) {

    // Loop through all subjects and print them in the table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["subject_id"] . "</td>";
        echo "<td>" . $row["subject_code"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["venue"] . "</td>";
        echo "<td>" . $row["student_number"] . "</td>";
        echo "<td>" . $row["subject_status"] . "</td>";
        echo "<td>" . $row["lecture_date"] . "</td>";
        echo "<td>" . $row["lecture_time"] . "</td>";
        echo "<td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='subject_id' value='" . $row["subject_id"] . "'>";
        echo "<input type='submit' name='teach' value='Teach'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>
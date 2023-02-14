<html>
<title>Subject List</title>
<form method="post">
<input type="submit" name="adminhome" value="Admin Home">
</form>
<h1>Subject List</h1>
<form method="post">
  <input type="submit" name="show_active" value="Active">
  <input type="submit" name="show_inactive" value="Inactive">
  <input type="submit" name="show_removed" value="Removed">
  <input type="submit" name="show_all" value="All">
</form>
<form method="post" action="">
  <input type="text" name="search_query">
  <select id="search_by" name="search_by">
        <option value="subject_name">Search by Name</option>
        <option value="subject_id">Search by ID</option>
        <option value="subject_code">Search by Subject Code</option>
        <option value="venue">Search by Venue</option>
        <option value="all">Search by All</option>
  </select>
  <input type="submit" value="Search" name="search">
</form>
<table border="1">
    <thead>
        <tr>
            <th>Subject ID</th>
            <th>Subject Code</th>
            <th>Name</th>
            <th>Lecturer</th>
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

session_start();

if (isset($_POST['adminhome'])) {
  header("Location: adminhome.php");
  exit;
}

if(!isset($_SESSION["rid"]) || $_SESSION["rid"] != 1) {
  header("Location: index.php");
  exit;
}



// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_enrollment";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select all data from the table "subject"
$sql = "SELECT * FROM subject";
$result = mysqli_query($conn, $sql);

if (isset($_POST['show_active'])) {
    $sql = "SELECT * FROM subject WHERE subject_status='active'";
    $result = mysqli_query($conn, $sql);
}

if (isset($_POST['show_inactive'])) {
    $sql = "SELECT * FROM subject WHERE subject_status='inactive'";
    $result = mysqli_query($conn, $sql);
}

if (isset($_POST['show_removed'])) {
    $sql = "SELECT * FROM subject WHERE subject_status='removed'";
    $result = mysqli_query($conn, $sql);
}

if (isset($_POST['show_all'])) {
    $sql = "SELECT * FROM subject";
    $result = mysqli_query($conn, $sql);
}

if (isset($_POST['search'])) {
    $search_term = $_POST['search_query'];
    $search_by = $_POST['search_by'];
    if ($search_by == 'subject_name') {
        $sql = "SELECT * FROM subject WHERE name LIKE '%$search_term%'";
    } else if ($search_by == 'subject_id') {
        $sql = "SELECT * FROM subject WHERE subject_id = '$search_term'";
    } else if ($search_by == 'subject_code') {
        $sql = "SELECT * FROM subject WHERE subject_code = '$search_term'";
    } else if ($search_by == 'venue') {
        $sql = "SELECT * FROM subject WHERE venue = '$search_term'";
    } else if ($search_by == 'all') {
        $sql = "SELECT * FROM subject WHERE subject_code LIKE '%$search_term%' OR name LIKE '%$search_term%' OR lecturer LIKE '%$search_term%' OR venue LIKE '%$search_term%' OR student_number LIKE '%$search_term%' OR subject_status LIKE '%$search_term%' OR lecture_date LIKE '%$search_term%' OR lecture_time LIKE '%$search_term%'";
    }
    $result = mysqli_query($conn, $sql);
}




// Check if there are any subjects in the table
if (mysqli_num_rows($result) > 0) {
    // echo "<table>";
    // echo "<tr>";
    // echo "<th>Subject ID</th>";
    // echo "<th>Subject Code</th>";
    // echo "<th>Name</th>";
    // echo "<th>Lecturer</th>";
    // echo "<th>Venue</th>";
    // echo "<th>Student Number</th>";
    // echo "<th>Subject Status</th>";
    // echo "<th>Lecture Date</th>";
    // echo "<th>Lecture Time</th>";
    // echo "<th>Actions</th>";
    // echo "</tr>";

    // Loop through all subjects and print them in the table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["subject_id"] . "</td>";
        echo "<td>" . $row["subject_code"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["lecturer"] . "</td>";
        echo "<td>" . $row["venue"] . "</td>";
        echo "<td>" . $row["student_number"] . "</td>";
        echo "<td>" . $row["subject_status"] . "</td>";
        echo "<td>" . $row["lecture_date"] . "</td>";
        echo "<td>" . $row["lecture_time"] . "</td>";
        echo "<td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='subject_id' value='" . $row["subject_id"] . "'>";
        echo "<input type='submit' name='edit_subject' value='Edit'>";
        echo "<input type='submit' name='delete_subject' value='Delete'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
// Check if the "Delete" button was clicked
if (isset($_POST["delete_subject"])) {
    // Get the subject ID for the selected subject
    $subject_id = $_POST["subject_id"];

    // Delete the selected subject from the database
    $sql = "DELETE FROM subject WHERE subject_id = $subject_id";
    $result = mysqli_query($conn, $sql);

    // Check if the subject was successfully deleted
    if ($result) {
        header("Location: subject.php");
    } else {
        echo "Error deleting subject: " . mysqli_error($conn);
    }
}

// Check if the "Edit" button was clicked
if (isset($_POST["edit_subject"])) {
    // Get the subject information for the selected subject
    $subject_id = $_POST["subject_id"];
    $sql = "SELECT * FROM subject WHERE subject_id = $subject_id";
    $result = mysqli_query($conn, $sql);
    $subject = mysqli_fetch_assoc($result);

    // Display the edit form
    echo "<form method='post'>";
    echo "<input type='hidden' name='subject_id' value='" . $subject["subject_id"] . "'>";
    echo "<label>Subject Code:</label>";
    echo "<input type='text' name='subject_code' value='" . $subject["subject_code"] . "'><br>";
    echo "<label>Name:</label>";
    echo "<input type='text' name='name' value='" . $subject["name"] . "'><br>";
    echo "<label>Lecturer:</label>";
    echo "<input type='text' name='lecturer' value='" . $subject["lecturer"] . "'><br>";
    echo "<label>Venue:</label>";
    echo "<input type='text' name='venue' value='" . $subject["venue"] . "'><br>";
    echo "<label>Student Number:</label>";
    echo "<input type='text' name='student_number' value='" . $subject["student_number"] . "'><br>";
    echo "<label>Subject Status:</label>";
    echo "<select name='subject_status' id='subject_status' value='" . $subject["subject_status"] . "'><br>";
    echo "<option value='active'>active</option>";
    echo "<option value='inactive'>inactive</option>";
    echo "<option value='removed'>removed</option>";
    echo "</select><br>";
    echo "<label>Lecture Date:</label>";
    echo "<input type='text' name='lecture_date' value='" . $subject["lecture_date"] . "'><br>";
    echo "<label>Lecture Time:</label>";
    echo "<input type='text' name='lecture_time' value='" . $subject["lecture_time"] . "'><br>";
    echo "<input type='submit' name='update_subject' value='Update'>";
    echo "<input type='submit' name='cancel' value='Cancel'>";
    echo "</form>";
}

// Check if the "Update" button was clicked
if (isset($_POST["update_subject"])) {
// Get the updated subject information
$subject_id = $_POST["subject_id"];
$subject_code = $_POST["subject_code"];
$name = $_POST["name"];
$lecturer = $_POST["lecturer"];
$venue = $_POST["venue"];
$student_number = $_POST["student_number"];
$subject_status = $_POST["subject_status"];
$lecture_date = $_POST["lecture_date"];
$lecture_time = $_POST["lecture_time"];
// Update the subject information in the database
$sql = "UPDATE subject SET subject_code = '$subject_code', name = '$name', lecturer = '$lecturer', venue = '$venue', student_number = '$student_number', subject_status = '$subject_status', lecture_date = '$lecture_date', lecture_time = '$lecture_time' WHERE subject_id = $subject_id";
$result = mysqli_query($conn, $sql);

// Check if the update was successful
if ($result) {
    // Redirect to the subject list page
    header("Location: subject.php");
    exit;
} else {
    echo "Error updating subject: " . mysqli_error($conn);
}
}
// Check if the "Cancel" button was clicked
if (isset($_POST["cancel"])) {
    // Redirect to the subject list page
    header("Location: subject.php");
    exit;
    }


// Close the connection
mysqli_close($conn);

?>
    </tbody>
</table>

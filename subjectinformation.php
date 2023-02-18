<title>Subject Enrollment</title>
<form method="post">
<input type="submit" name="studenthome" value="Student Home">
</form>
<?php
session_start();
echo "Logged in as " . $_SESSION['username'];

if (isset($_POST['studenthome'])) {
    header("Location: studenthome.php");
    exit;
  }

  if(!isset($_SESSION["rid"]) || $_SESSION["rid"] != 3) {
    header("Location: index.php");
    exit;
  }

?>
<h1>Subject Information</h1>
<form method="post" action="">
  <input type="text" name="search_query" placeholder="Search Subject" required>
  <select id="search_by" name="search_by">
        <option value="subject_name">Search by Name</option>
        <option value="subject_id">Search by ID</option>
        <option value="subject_code">Search by Subject Code</option>
        <option value="venue">Search by Venue</option>
        <option value="educator_names">Search by Lecturer</option>
        <option value="all">Search by All</option>
  </select>
  <input type="submit" value="Search" name="search">
</form>
<form method="post">
    <input type="submit" name="all" value="List All">
</form>
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
            <th>Lecturer Name</th>
        </tr>
    </thead>
    <tbody>
<?php
// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'online_enrollment';
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}




// Select all data from the table "subject"
// $sql = "SELECT s.subject_id, s.subject_code, s.name, s.venue, s.student_number, s.subject_status, s.lecture_date, s.lecture_time, GROUP_CONCAT(e.name SEPARATOR '<br> ') AS educator_names
// FROM subject s
// LEFT JOIN educator e ON FIND_IN_SET(s.name, e.teaching_subjects) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(SUBSTRING_INDEX(e.teaching_subjects, ', ', -2), ', ', 1)) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(e.teaching_subjects, ', ', -1)) > 0
// GROUP BY s.subject_id;";
// $result = mysqli_query($conn, $sql);

// Handle search form submission
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $search_by = $_POST['search_by'];
    $sql = "SELECT s.subject_id, s.subject_code, s.name, s.venue, s.student_number, s.subject_status, s.lecture_date, s.lecture_time, GROUP_CONCAT(e.name SEPARATOR '<br> ') AS educator_names
            FROM subject s
            LEFT JOIN educator e ON FIND_IN_SET(s.name, e.teaching_subjects) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(SUBSTRING_INDEX(e.teaching_subjects, ', ', -2), ', ', 1)) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(e.teaching_subjects, ', ', -1)) > 0";
    switch ($search_by) {
      case 'subject_name':
        $sql .= " WHERE s.name LIKE '%$search_query%'";
        break;
      case 'subject_id':
        $sql .= " WHERE s.subject_id LIKE '%$search_query%'";
        break;
      case 'subject_code':
        $sql .= " WHERE s.subject_code LIKE '%$search_query%'";
        break;
      case 'venue':
        $sql .= " WHERE s.venue LIKE '%$search_query%'";
        break;
      case 'educator_names':
        $sql .= " WHERE e.name LIKE '%$search_query%'";
        break;
      case 'all':
        $sql .= " WHERE s.name LIKE '%$search_query%'
                  OR s.subject_id LIKE '%$search_query%'
                  OR s.subject_code LIKE '%$search_query%'
                  OR s.venue LIKE '%$search_query%'
                  OR e.name LIKE '%$search_query%'";
        break;
    }
    $sql .= " GROUP BY s.subject_id;";
    $result = mysqli_query($conn, $sql);
  } else {
    // Select all data from the table "subject"
    $sql = "SELECT s.subject_id, s.subject_code, s.name, s.venue, s.student_number, s.subject_status, s.lecture_date, s.lecture_time, GROUP_CONCAT(e.name SEPARATOR '<br> ') AS educator_names
            FROM subject s
            LEFT JOIN educator e ON FIND_IN_SET(s.name, e.teaching_subjects) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(SUBSTRING_INDEX(e.teaching_subjects, ', ', -2), ', ', 1)) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(e.teaching_subjects, ', ', -1)) > 0
            GROUP BY s.subject_id;";
    $result = mysqli_query($conn, $sql);
  }

if (isset($_POST['all'])) {
    $sql = "SELECT s.subject_id, s.subject_code, s.name, s.venue, s.student_number, s.subject_status, s.lecture_date, s.lecture_time, GROUP_CONCAT(e.name SEPARATOR '<br> ') AS educator_names
FROM subject s
LEFT JOIN educator e ON FIND_IN_SET(s.name, e.teaching_subjects) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(SUBSTRING_INDEX(e.teaching_subjects, ', ', -2), ', ', 1)) > 0 OR FIND_IN_SET(s.name, SUBSTRING_INDEX(e.teaching_subjects, ', ', -1)) > 0
GROUP BY s.subject_id;";
$result = mysqli_query($conn, $sql);
}


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
        echo "<td>" . $row["educator_names"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the database connection
mysqli_close($conn);
?>
</table>
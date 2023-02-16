<!DOCTYPE html>
<title>Student List</title>
<form method="post">
<input type="submit" name="educatorhome" value="Educator Home">
</form>
<?php
session_start();
echo "Logged in as " . $_SESSION['username'];
?>
<h1>Student List</h1>
<form method="post">
  <input type="submit" name="show_active" value="List Active Students">
  <input type="submit" name="show_withdrawn" value="List Withdrawn Students">
  <input type="submit" name="show_all" value="List All">
</form><br>
<form method="post">
  <input type="submit" name="my_student" value="List My Students">
</form><br>
<form method="post" action="">
  <input type="text" name="search_query" placeholder="Search Student" required>
  <select id="search_by" name="search_by">
        <option value="student_name">Search by Name</option>
        <option value="student_id">Search by ID</option>
        <option value="phone">Search by Phone</option>
        <option value="email">Search by Email</option>
        <option value="enrolled_subjects">Search by Enrolled Subjects</option>
        <option value="all">Search by All</option>
  </select>
  <input type="submit" value="Search" name="search">
</form>
<table border="1">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Enrolled Subjects</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
<?php



if (isset($_POST['educatorhome'])) {
  header("Location: educatorhome.php");
  exit;
}

if(!isset($_SESSION["rid"]) || $_SESSION["rid"] != 2) {
  header("Location: index.php");
  exit;
}


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online_enrollment";
        // Connect to the database
        $conn = mysqli_connect("$servername", "$username", "$password", "$dbname");

        // Check the connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch the data from the database
        $sql = "SELECT * FROM student";
        $result = mysqli_query($conn, $sql);

        if (isset($_POST['show_active'])) {
            $sql = "SELECT * FROM student WHERE student_status='active'";
            $result = mysqli_query($conn, $sql);
        }
        
        if (isset($_POST['show_withdrawn'])) {
            $sql = "SELECT * FROM student WHERE student_status='withdrawn'";
            $result = mysqli_query($conn, $sql);
        }
        
        if (isset($_POST['show_all'])) {
            $sql = "SELECT * FROM student";
            $result = mysqli_query($conn, $sql);
        }

        if (isset($_POST['search'])) {
            $search_term = $_POST['search_query'];
            $search_by = $_POST['search_by'];
            if ($search_by == 'student_name') {
                $sql = "SELECT * FROM student WHERE name LIKE '%$search_term%'";
            } else if ($search_by == 'student_id') {
                $sql = "SELECT * FROM student WHERE student_id = '$search_term'";
            } else if ($search_by == 'phone') {
                $sql = "SELECT * FROM student WHERE phone = '$search_term'";
            } else if ($search_by == 'email') {
                $sql = "SELECT * FROM student WHERE email = '$search_term'";
            } else if ($search_by == 'enrolled_subjects') {
                $sql = "SELECT * FROM student WHERE enrolled_subjects LIKE '%$search_term%'";
            } else if ($search_by == 'all') {
                $sql = "SELECT * FROM student WHERE student_id LIKE '%$search_term%' OR name LIKE '%$search_term%' OR phone LIKE '%$search_term%' OR email LIKE '%$search_term%' OR enrolled_subjects LIKE '%$search_term%' OR student_status LIKE '%$search_term%'";
            }
            $result = mysqli_query($conn, $sql);
        }

        // if (isset($_POST['my_student'])) {
        //     $teaching_subjects = $_SESSION['teaching_subjects'];
        //     $sql = "SELECT * FROM student WHERE enrolled_subjects LIKE '%$teaching_subjects%'";
        //     $result = mysqli_query($conn, $sql);
        // }

        if (isset($_POST['my_student'])) {
            $teaching_subjects = explode(", ", $_SESSION['teaching_subjects']);
            $search_condition = "";
            foreach ($teaching_subjects as $subject) {
                $search_condition .= "enrolled_subjects LIKE '%$subject%' OR ";
            }
            $search_condition = rtrim($search_condition, " OR ");
            $sql = "SELECT * FROM student WHERE $search_condition";
            $result = mysqli_query($conn, $sql);
        }

        // Loop through the data and display it in the table
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["enrolled_subjects"] . "</td>";
                echo "<td>" . $row["student_status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "No data found in the database.";
        }

        // Close the connection
        mysqli_close($conn);
?>
    </tbody>
</table>

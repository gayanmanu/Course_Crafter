<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CourseCraftersDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    // Retrieve class ID from the form
    $class_id = $_POST['class_id'];

    // Update the status of the course to "approved"
    $update_sql = "UPDATE courses SET status = 'approved' WHERE class_id = '$class_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo '<script>alert("Course approved successfully."); window.location.href="adminDashboard.php";</script>';
    } else {
        echo '<script>alert("Error: ' . $conn->error . '"); window.history.back();</script>';
    }
}

$conn->close();
?>

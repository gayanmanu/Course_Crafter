<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the teacher ID from the form
    $teacher_id = $conn->real_escape_string($_POST['teacher_id']);

    // Update the teacher's status to 'approved'
    $sql = "UPDATE teachers SET status = 'approved' WHERE teacher_id = $teacher_id";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Lecturer approved successfully"); window.location.href="approveLec.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

// Redirect back to the pending teachers page

?>

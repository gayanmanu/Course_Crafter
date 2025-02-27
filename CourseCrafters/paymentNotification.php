<?php
session_start();

// Check if the user ID and course ID are set in the session
if (isset($_SESSION['user_id']) && isset($_SESSION['course_id'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_SESSION['course_id'];
} else {
    die("User ID or Course ID not found in session.");
}

// Check if payment status is received
if (!isset($_POST['status']) || $_POST['status'] != 'SUCCESS') {
    die("Invalid payment status.");
}

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

// Insert payment record into coursepayment table
$payment_date = date('Y-m-d');
$sql = "INSERT INTO coursepayment (user_id, course_id, payment_date) VALUES ('$user_id', '$course_id', '$payment_date')";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Payment record inserted successfully."); window.location.href="singleCourse.php";</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>

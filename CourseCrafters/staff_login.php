<?php
session_start(); // Start or resume the session

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
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Fetch staff details from the database
    $sql = "SELECT * FROM staff WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $staff_id = $row['staff_id']; // Retrieve staff_id from the database

        // Store staff_id in session
        $_SESSION['staff_id'] = $staff_id;

        $position = $row['position'];

        // Redirect based on the staff position
        switch ($position) {
            case 'Coordinator':
                header("Location: coordinatorHome.php");
                exit();
            case 'Course Reviewer':
                header("Location: courseReviewerHome.php");
                exit();
            case 'Accountant':
                header("Location: accountantHome.php");
                exit();
            case 'Admin':
                header("Location: adminHome.php");
                exit();
            default:
                echo "Invalid position";
                break;
        }
    } else {
        echo "Invalid email or password";
    }
}

$conn->close();
?>

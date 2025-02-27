<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle feedback submission
    if (isset($_SESSION['user_id']) && isset($_POST['course_id']) && isset($_POST['rating']) && isset($_POST['feedback'])) {
        $user_id = $_SESSION['user_id'];
        $course_id = $_POST['course_id'];
        $rating = $_POST['rating'];
        $feedback = $_POST['feedback'];

        $stmt = $conn->prepare("INSERT INTO course_feedback (course_id, user_id, rating, feedback) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $course_id, $user_id, $rating, $feedback);

        if ($stmt->execute()) {
            echo "Feedback submitted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
} else {

// Handle feedback retrieval
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    $stmt = $conn->prepare("SELECT cf.*, u.email FROM course_feedback cf INNER JOIN users u ON cf.user_id = u.id WHERE cf.course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $feedbacks = [];
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }

    echo json_encode($feedbacks);
    $stmt->close();
} else {
    echo json_encode([]);
}
}






$conn->close();
?>

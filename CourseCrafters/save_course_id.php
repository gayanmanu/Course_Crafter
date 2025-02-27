<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
    // Save the course ID in the session
    $_SESSION['course_id'] = $_POST['course_id'];
    echo "Course ID saved in session.";
} else {
    echo "Invalid request.";
}
?>

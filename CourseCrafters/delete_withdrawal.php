<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['teacher_id'])) {
    if (isset($_POST['delete'])) {
        $withdrawal_id = $_POST['withdrawal_id'];

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

        // SQL query to delete the withdrawal
        $sql = "DELETE FROM withdrawal WHERE withdrawal_id = ? AND teacher_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $withdrawal_id, $_SESSION['teacher_id']);

        if ($stmt->execute()) {
            // Redirect to the same page to see the result
            header("Location: withdrawal.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    // If user is not logged in, redirect to login page
    header("Location: lecturerReg.php");
    exit();
}
?>

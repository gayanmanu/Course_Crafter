<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

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
        $message = $_POST['message'];
        $inquiry_date = date('Y-m-d');
        $status = 'pending'; // Default status for new inquiries

        // Fetch the user's email from the users table
        $sql = "SELECT email FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();

        // Insert the inquiry into the database
        $sql = "INSERT INTO inquiry (user_id, email, inquiry_date, message, status)
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $email, $inquiry_date, $message, $status);

        if ($stmt->execute()) {
            echo '<script>alert("Inquiry submitted successfully!"); window.location.href="Inquiry_form.php";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
} else {
    // If user is not logged in, redirect to login page
    header("Location: register.php");
    exit();
}
?>

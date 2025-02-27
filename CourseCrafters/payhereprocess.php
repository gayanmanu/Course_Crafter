<?php
session_start();

// Check if the user ID and course ID are set in the session
if (isset($_SESSION['user_id']) && isset($_SESSION['course_id'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_SESSION['course_id'];
} else {
    die("User ID or Course ID not found in session.");
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

// Fetch the course fee from the courses table
$sql = "SELECT course_fee FROM courses WHERE class_id = '$course_id'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Course not found.");
}
$row = $result->fetch_assoc();
$amount = $row['course_fee'];

// Payment processing details
$merchant_id = "1226143";
$order_id = uniqid();
$merchant_secret = "MzY1MDE5MjAyOTQyMTU1MDIwNTczOTk2MDIxNDY3MzU2NTQyOTg2MQ==";
$currency = "LKR";

$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);

$array = [];
$array["amount"] = $amount;
$array["merchant_id"] = $merchant_id;
$array["order_id"] = $order_id;
$array["merchant_secret"] = $merchant_secret;
$array["currency"] = $currency;
$array["hash"] = $hash;

$jsonObj = json_encode($array);
echo $jsonObj;

$conn->close();
?>

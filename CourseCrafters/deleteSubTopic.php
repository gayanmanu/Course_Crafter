<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CourseCraftersDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sub_topic_id = $_POST['sub_topic_id'] ?? null;
if (!$sub_topic_id) {
    die("Sub-topic ID is not set.");
}

$sql = "DELETE FROM sub_topics WHERE sub_topic_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sub_topic_id);
if ($stmt->execute()) {
    echo "Sub-topic deleted successfully.";
} else {
    echo "Error deleting sub-topic: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

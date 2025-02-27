<?php
// deleteMainTopic.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CourseCraftersDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['main_topic_id'])) {
        $main_topic_id = $_POST['main_topic_id'];

        // Delete associated sub-topics first
        $sql = "DELETE FROM sub_topics WHERE main_topic_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $main_topic_id);
        if ($stmt->execute()) {
            // Then delete the main topic
            $sql = "DELETE FROM main_topics WHERE main_topic_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $main_topic_id);
            if ($stmt->execute()) {
                echo "Main topic and its sub-topics deleted successfully.";
            } else {
                echo "Error deleting main topic: " . $conn->error;
            }
        } else {
            echo "Error deleting sub-topics: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Main topic ID not provided.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>

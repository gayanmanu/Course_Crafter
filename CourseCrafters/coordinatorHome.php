<?php 
session_start(); 
if (!isset($_SESSION['staff_id'])) {
    header("Location: staffLogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course Reviewer Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background: url('cover.jpg') center center/cover no-repeat fixed;
        }

        .content-overlay {
            position: absolute;
            top: 0;
            left: 0;
            
            height: auto;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

/* styles.css */

table {
    width: 80%;
    border-collapse: collapse;
    margin: 0 auto; /* Center the table horizontally */
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

th {
    background-color: #dddddd;
}

input[type='submit'] {
    padding: 8px; /* Adjust button padding */
    margin: 4px 0; /* Adjust button margin */
    border: none;
    border-radius: 4px;
    background-color: #4CAF50; /* Button color */
    color: white;
    cursor: pointer;
    width: 50%; /* Ensure all buttons have the same width */
}

input[type='text'] {
    padding: 8px; /* Adjust button padding */
    margin: 4px 0; /* Adjust button margin */
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    width: 95%; /* Ensure all buttons have the same width */
}

/* Set delete button color to red */
input[name='delete_reply'] {
    background-color: #ff0000;
}


        


    </style>
</head>


<body>
    <div class="content-overlay">
    <!-- Navigation Bar -->
    <div style="width:100%;">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #000000; width: 100%;">
            <li style="float: left; padding-left: 30px; height: 80px;">
                <a href="coordinatorHome.php" style="display: block; height: 100%;">
                    <img src="logo-no-background.png" alt="Logo" style="height: 50px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="coordinatorHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Coordinator Home
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="admin_inquiries.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Inquiries</a>
            </li>


            <li style="float: right; margin-right: 30px; margin-left: 30px; padding-top: 10px;">
                <a href="#profile" style="display: block; color: white; text-align: center; text-decoration: none;">
                    <img src="profile.png" alt="icon" style="height: 30px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: right; padding-top: 20px;">
                <a href="#whatsapp" style="display: block; color: white; text-align: center; text-decoration: none;">
                    <img src="whatsapp.png" alt="icon" style="height: 15px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: right; padding-top: 20px;">
                <a href="#instagram" style="display: block; color: white; text-align: center; text-decoration: none;">
                    <img src="instagram.png" alt="icon" style="height: 15px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: right; padding-top: 20px;">
                <a href="https://www.facebook.com/" style="display: block; color: white; text-align: center; text-decoration: none;">
                    <img src="facebook.png" alt="icon" style="height: 15px; width: auto; padding: 10px;">
                </a>
            </li>
        </ul>

        <ul style="list-style-type: none; margin: 0; padding-bottom: 20px; overflow: hidden; background-color: #000000; max-width: 100%;">
            <li style="float: right; padding-top: 20px;">
                <span id="datetime" style="color: white; text-align: center; padding-right: 80px;"></span>
            </li>

        </ul>


        <script>
            function showCategoryItems() {
                document.getElementById("categoryList").style.display = "block";
            }
            function hideCategoryItems() {
                document.getElementById("categoryList").style.display = "none";
            }
        </script>

        <script>
            function updateDateTime() {
                var dateTimeElement = document.getElementById("datetime");
                if (dateTimeElement) {
                    var now = new Date();
                    var options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        second: 'numeric',
                        timeZone: 'Asia/Colombo'  // Set timeZone to "UTC" to remove the GMT offset
                    };
                    var dateTimeString = now.toLocaleDateString(undefined, options);
                    dateTimeElement.textContent = dateTimeString;
                }
            }

            // Update every second
            setInterval(updateDateTime, 1000);
            // Initial update
            updateDateTime();
        </script>

    </div>



<h1 style="text-align: center; margin-top: 5%; margin-bottom: 2%">Feedbacks & Ratings</h1>

<?php
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

// Function to display alert message
function showAlert($message, $type = 'success') {
    echo "<script>";
    echo "alert('$message');";
    echo "</script>";
}

// Check if form is submitted for adding reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reply']) && isset($_POST['feedback_id']) && isset($_POST['reply'])) {
    $feedback_id = $_POST['feedback_id'];
    $reply = $_POST['reply'];

    // Prepare SQL statement to add reply
    $stmt = $conn->prepare("UPDATE course_feedback SET reply = ? WHERE feedback_id = ?");
    $stmt->bind_param("si", $reply, $feedback_id);

    if ($stmt->execute()) {
        showAlert("Reply added successfully.");
    } else {
        showAlert("Error: " . $stmt->error, 'error');
    }

    $stmt->close();
}

// Check if form is submitted for updating reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_reply']) && isset($_POST['feedback_id']) && isset($_POST['reply'])) {
    $feedback_id = $_POST['feedback_id'];
    $reply = $_POST['reply'];

    // Prepare SQL statement to update reply
    $stmt = $conn->prepare("UPDATE course_feedback SET reply = ? WHERE feedback_id = ?");
    $stmt->bind_param("si", $reply, $feedback_id);

    if ($stmt->execute()) {
        showAlert("Reply updated successfully.");
    } else {
        showAlert("Error: " . $stmt->error, 'error');
    }

    $stmt->close();
}

// Check if form is submitted for deleting reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_reply']) && isset($_POST['feedback_id'])) {
    $feedback_id = $_POST['feedback_id'];

    // Prepare SQL statement to delete reply
    $stmt = $conn->prepare("UPDATE course_feedback SET reply = NULL WHERE feedback_id = ?");
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        showAlert("Reply deleted successfully.");
    } else {
        showAlert("Error: " . $stmt->error, 'error');
    }

    $stmt->close();
}

// Retrieve feedback data in descending order by ID
$sql = "SELECT cf.*, u.email FROM course_feedback cf INNER JOIN users u ON cf.user_id = u.id ORDER BY cf.feedback_id DESC";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // Output feedback table header
    echo "<table>";
    echo "<tr><th>ID</th><th>Course ID</th><th>User ID</th><th>Rating</th><th>Feedback</th><th>Created At</th><th>Reply</th><th>Actions</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["feedback_id"] . "</td>";
        echo "<td>" . $row["course_id"] . "</td>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["rating"] . "</td>";
        echo "<td>" . $row["feedback"] . "</td>";
        echo "<td>" . $row["created_at"] . "</td>";
        echo "<td>" . $row["reply"] . "</td>";
        echo "<td>";

        // Add form for adding reply
        echo "<form method='post' action='".$_SERVER["PHP_SELF"]."'>";
        echo "<input type='hidden' name='feedback_id' value='".$row["feedback_id"]."'>";
        echo "<input type='text' name='reply'>";
        echo "<input type='submit' name='add_reply' value='Add Reply'>";
        echo "</form>";

        // Add form for updating reply
        echo "<form method='post' action='".$_SERVER["PHP_SELF"]."'>";
        echo "<input type='hidden' name='feedback_id' value='".$row["feedback_id"]."'>";
        echo "<input type='text' name='reply' value='".$row["reply"]."'>";
        echo "<input type='submit' name='update_reply' value='Update Reply'>";
        echo "</form>";

        // Add form for deleting reply
        echo "<form method='post' action='".$_SERVER["PHP_SELF"]."'>";
        echo "<input type='hidden' name='feedback_id' value='".$row["feedback_id"]."'>";
        echo "<input type='submit' name='delete_reply' value='Delete Reply'>";
        echo "</form>";

        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>

<div style="margin-top: 7%"><?php include 'footer.php'; ?></div>   

    

</body>
</html>
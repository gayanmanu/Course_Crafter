<?php 
session_start(); 
if (!isset($_SESSION['staff_id'])) {
    header("Location: staffLogin.php");
    exit();
}
?>
<?php
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

// Handle form submission for response
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inquiry_id = $_POST['inquiry_id'];
    $response = $_POST['response'];
    $status = $_POST['status'];

    // Update the inquiry with the response and status
    $sql = "UPDATE inquiry SET response = ?, status = ? WHERE inquiry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $response, $status, $inquiry_id);
    $stmt->execute();
    $stmt->close();
}

// Handle delete request
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $inquiry_id = $_GET['delete'];
    $sql = "DELETE FROM inquiry WHERE inquiry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inquiry_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_inquiries.php");
    exit();
}

// Fetch all inquiries
$sql = "SELECT i.inquiry_id, i.user_id, u.email, i.inquiry_date, i.message, i.status, i.response 
        FROM inquiry i 
        JOIN users u ON i.user_id = u.id";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coordinator Inquiries</title>
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

        .inquiry-list {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 50%;
            margin: auto;
            margin-top: 8%;
            margin-bottom: 3%;
        }
        .inquiry-list h2 {
            margin-top: 0;
        }
        .inquiry-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .inquiry-list table, .inquiry-list th, .inquiry-list td {
            border: 1px solid #ddd;
        }
        .inquiry-list th, .inquiry-list td {
            padding: 8px;
            text-align: left;
        }
        .inquiry-list th {
            background-color: #f2f2f2;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container textarea{
            width: 97.5%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 2%;
        }
        .form-container input[type="text"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container textarea {
            height: 100px;
        }
        .form-container input[type="submit"] {
            display: block;
            margin-top: 10px;
            padding: 10px 15px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons a {
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #007bff;
        }
        .action-buttons a.delete {
            background-color: #dc3545;
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
                <a href="coordinatorHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Coordinator Home</a>
            </li>


            <li style="float: left; padding-top: 20px;">
                <a class="active" href="admin_inquiries.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Inquiries
                </a>
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

    <div class="inquiry-list">
        <h2>Manage Inquiries</h2>
        <?php
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Email</th><th>Date</th><th>Message</th><th>Status</th><th>Response</th><th>Actions</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['inquiry_date']) . '</td>';
                echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '<td>' . htmlspecialchars($row['response']) . '</td>';
                echo '<td class="action-buttons">';
                echo '<a href="admin_inquiries.php?edit=' . $row['inquiry_id'] . '">Edit</a>';
                echo '<a href="admin_inquiries.php?delete=' . $row['inquiry_id'] . '" class="delete">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No inquiries found.</p>';
        }
        ?>

        <?php
        // Display the edit form if edit action is triggered
        if (isset($_GET['edit']) && !empty($_GET['edit'])) {
            $inquiry_id = $_GET['edit'];
            $sql = "SELECT inquiry_id, response, status FROM inquiry WHERE inquiry_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $inquiry_id);
            $stmt->execute();
            $stmt->bind_result($inquiry_id, $response, $status);
            $stmt->fetch();
            $stmt->close();
        ?>
        <div class="form-container">
            <h3>Edit Response</h3>
            <form method="post" action="admin_inquiries.php">
                <input type="hidden" name="inquiry_id" value="<?php echo $inquiry_id; ?>">
                <label for="response">Response:</label>
                <textarea id="response" name="response" required><?php echo htmlspecialchars($response); ?></textarea>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="resolved" <?php echo $status == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                    <option value="closed" <?php echo $status == 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
                <input type="submit" value="Update Inquiry">
            </form>
        </div>
        <?php
        }
        $conn->close();
        ?>
    </div>











    <?php include 'footer.php'; ?>

    

</body>
</html>
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

// Check if staff_id is set in session
if (!isset($_SESSION['staff_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: staffLogin.php");
    exit(); // Ensure no further code execution
}

// Handle action buttons (Complete and Decline)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && isset($_POST['withdrawal_id'])) {
        $action = $_POST['action'];
        $withdrawal_id = $_POST['withdrawal_id'];

        if ($action == 'complete') {
            $sql = "UPDATE withdrawal SET status = 'completed' WHERE withdrawal_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $withdrawal_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'decline') {
            $sql = "UPDATE withdrawal SET status = 'declined' WHERE withdrawal_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $withdrawal_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fetch all pending withdrawals
$sql = "SELECT withdrawal_id, teacher_id, withdrawal_date, amount,account_number,account_branch,account_name,owner_name FROM withdrawal WHERE status = 'pending'";
$result = $conn->query($sql);
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Home</title>
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

        .pending-course-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .pending-course-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            box-sizing: border-box;
            position: relative;
            text-align: left;
            text-decoration: none;
        }
        .pending-course-item p {
            margin: 10px 0;
            color: #333;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .action-buttons button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-buttons button.complete {
            background-color: #28a745;
            color: white;
        }
        .action-buttons button.decline {
            background-color: #dc3545;
            color: white;
            margin-left: 10px;
        }

        


    </style>
</head>


<body>
    <div class="content-overlay">
    <!-- Navigation Bar -->
    <div style="width:100%;">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #000000; width: 100%;">
            <li style="float: left; padding-left: 30px; height: 80px;">
                <a href="accountantHome.php" style="display: block; height: 100%;">
                    <img src="logo-no-background.png" alt="Logo" style="height: 50px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="accountantHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Accountant Home
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="accountantReports.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Reports</a>
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

            <li style="float: right; padding-top: 10px; padding-right: 10px">
                <a href="staffLogin.php" style="display: block; color: white; text-align: center; text-decoration: none;">
                        <button style="padding: 10px 20px;
                          font-size: 13px;
                          cursor: pointer;
                          border: none;
                          border-radius: 5px;
                          background-color: #007bff;
                          color: #fff;
                          text-align: center;
                          text-decoration: none;
                          display: inline-block;
                          transition: background-color 0.3s ease;
                          margin: 10px;">
                          Logout
                      </button>
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



    <h2 style="text-align: center; margin-top: 5%;">Pending Withdrawals</h2>
    <div class="pending-course-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $amount = ($row['amount']) - (($row['amount'])/100*20);
                echo '<div class="pending-course-item">';

                echo '<h3>Withdrawal Details ' . '</h3>';
                echo '<p><strong>Withdrawal ID:</strong> ' . htmlspecialchars($row['withdrawal_id']) . '</p>';
                echo '<p><strong>Teacher ID:</strong> ' . htmlspecialchars($row['teacher_id']) . '</p>';
                echo '<p><strong>Withdrawal Date:</strong> ' . htmlspecialchars($row['withdrawal_date']) . '</p>';
                echo '<p><strong>Amount:</strong> ' . htmlspecialchars($amount) . '</p>';
                echo '<br/>';

                echo '<h3>Account Details ' . '</h3>';
                echo '<p><strong>Account Number:</strong> ' . htmlspecialchars($row['account_number']) . '</p>';
                echo '<p><strong>Account Branch:</strong> ' . htmlspecialchars($row['account_branch']) . '</p>';
                echo '<p><strong>Account Name:</strong> ' . htmlspecialchars($row['account_name']) . '</p>';
                echo '<p><strong>Owner Name:</strong> ' . htmlspecialchars($row['owner_name']) . '</p>';
                echo '<div class="action-buttons">';
                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<input type="hidden" name="withdrawal_id" value="' . $row['withdrawal_id'] . '">';
                echo '<button type="submit" name="action" value="complete" class="complete">Complete</button>';
                echo '<button type="submit" name="action" value="decline" class="decline">Decline</button>';
                echo '</form>';
                echo '</div>'; // action-buttons
                echo '</div>'; // pending-course-item
            }
        } else {
            echo '<p style="text-align: center; width: 100%;">No pending withdrawals found.</p>';
        }
        ?>
    </div>












    <div style="margin-top: 15%"><?php include 'footer.php'; ?></div>

    

</body>
</html>
<?php
$conn->close();
?>
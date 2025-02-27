<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

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

    // Query to calculate the current balance for the logged-in teacher
    $sql = "
    SELECT 
        t.teacher_id,
        t.first_name,
        t.last_name,
        COALESCE(SUM(course_payments.total_payment), 0) - COALESCE(SUM(withdrawals.total_withdrawal), 0) AS current_balance
    FROM 
        teachers t
    LEFT JOIN (
        SELECT 
            c.teacher_id,
            SUM(c.course_fee) AS total_payment
        FROM 
            courses c
        INNER JOIN 
            coursepayment cp ON c.class_id = cp.course_id
        GROUP BY 
            c.teacher_id
    ) course_payments ON t.teacher_id = course_payments.teacher_id
    LEFT JOIN (
        SELECT 
            teacher_id,
            SUM(amount) AS total_withdrawal
        FROM 
            withdrawal

        GROUP BY 
            teacher_id
    ) withdrawals ON t.teacher_id = withdrawals.teacher_id
    WHERE 
        t.teacher_id = $teacher_id
    GROUP BY 
        t.teacher_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $teacher_id = $row['teacher_id'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $current_balance = $row['current_balance'];
    } else {
        $teacher_id = "";
        $first_name = "";
        $last_name = "";
        $current_balance = 0;
    }

    $conn->close();
} else {
    // If user is not logged in, redirect to login page
    header("Location: lecturerReg.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Withdrawal</title>
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
        .content1{
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container23 {
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            width: 25%;
            border-radius: 2%;
            margin-left: 37.5%;
        }
        h1, h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .withdrawal-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
            margin: 20px;
        }
        .withdrawal-box {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 18%;
            border-radius: 2%;
            margin-top: 5%;
            box-sizing: border-box;
        }
        .withdrawal-box p {
            margin: 5px 0;
        }
        .delBtn {
            background-color: #f44336;
            color: white;
            padding: 5px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            height: 30px;
        }
        .delBtn:hover {
            background-color: #e53935;
        }

    </style>
</head>


<body>
    <div class="content-overlay">
    <!-- Navigation Bar -->
    <div style="width:100%;">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #000000; width: 100%;">
            <li style="float: left; padding-left: 30px; height: 80px;">
                <a href="LecHome.php" style="display: block; height: 100%;">
                    <img src="logo-no-background.png" alt="Logo" style="height: 50px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="LecHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Home</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="LecDashboard.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Add Courses</a>
            </li>


            <li style="float: left; padding-top: 20px;">
                <a class="active" href="withdrawal.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Withrawal
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="salesChart.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Sales Chart</a>
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
                <a href="lecturerReg.php" style="display: block; color: white; text-align: center; text-decoration: none;">
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




    <!-- Main Content -->
    <main>
        <div class="content1">
            <h1>Welcome, <?php echo $first_name . " " . $last_name; ?></h1>
            <?php if ($current_balance > 0): ?>
                <p>Your current balance is: $<?php echo $current_balance; ?></p>
            <?php else: ?>
                <p>Your current balance is: $0.00</p>
            <?php endif; ?>
        </div>
    </main>

    <div class="form-container23">
        <h2>Withdrawal Request</h2>
        <form action="process_withdrawal.php" method="POST">
            <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
            <label for="amount">Withdrawal Amount ($):</label>
            <input type="number" id="amount" name="amount" step="0.01" min="0.01" max="<?php echo $current_balance; ?>" required>
            <br><br>
            <label for="account_number">Account Number:</label>
            <input type="number" id="account_number" name="account_number" required>
            <br><br>
            <label for="account_branch">Account Branch:</label>
            <input type="text" id="account_branch" name="account_branch" required>
            <br><br>
            <label for="account_name">Account Name:</label>
            <input type="text" id="account_name" name="account_name" required>
            <br><br>
            <label for="owner_name">Owner Name:</label>
            <input type="text" id="owner_name" name="owner_name" required>
            <br><br>
            <button type="submit" name="submit">Submit Withdrawal Request</button>
            <p style="color: red;">The system charges a service charge of 20% on every withdrawal.</p>
        </form>
    </div>

<?php


// Check if the user is logged in
if(isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

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

    // Query to fetch both pending and completed withdrawals for the logged-in teacher
    $sql = "
    SELECT 
        withdrawal_id,
        withdrawal_date,
        amount,
        status,
        account_number,
        account_branch,
        account_name,
        owner_name
    FROM 
        withdrawal
    WHERE 
        teacher_id = $teacher_id";

    $result = $conn->query($sql);

    echo "<div class='withdrawal-container'>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='withdrawal-box'>";
            echo "<p><strong>Withdrawal ID:</strong> " . $row["withdrawal_id"] . "</p>";
            echo "<p><strong>Date:</strong> " . $row["withdrawal_date"] . "</p>";
            echo "<p><strong>Amount:</strong> $" . number_format($row["amount"], 2) . "</p>";
            echo "<p><strong>Status:</strong> " . $row["status"] . "</p>";
            echo "<p><strong>Account Number:</strong> " . $row["account_number"] . "</p>";
            echo "<p><strong>Account Branch:</strong> " . $row["account_branch"] . "</p>";
            echo "<p><strong>Account Name:</strong> " . $row["account_name"] . "</p>";
            echo "<p><strong>Owner Name:</strong> " . $row["owner_name"] . "</p>";

            // Check if status is 'Completed' to disable delete button
            if ($row["status"] == 'completed') {
                echo "<p style='color: red;'>Deletion not allowed for Completed withdrawals.</p>";
            } else {
                echo "<form action='delete_withdrawal.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this withdrawal?\");'>";
                echo "<input type='hidden' name='withdrawal_id' value='" . $row["withdrawal_id"] . "'>";
                echo "<button type='submit' name='delete' class='delBtn'>Delete</button>";
                echo "</form>";
            }
            
            echo "</div>"; // withdrawal-box
        }
    } else {
        echo "No withdrawals found.";
    }

    echo "</div>"; // withdrawal-container

    $conn->close();
} else {
    // If user is not logged in, redirect to login page
    header("Location: lecturerReg.php");
    exit();
}
?>









    <?php include 'footer.php'; ?>

    

</body>
</html>
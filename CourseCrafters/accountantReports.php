<?php
session_start(); // Start the session to access session variables

// Check if staff_id is set in session
if (!isset($_SESSION['staff_id'])) {
    // Redirect to login page or appropriate error handling
    header("Location: staffLogin.php");
    exit(); // Ensure that script stops here
}

$staff_id = $_SESSION['staff_id']; // Retrieve staff_id from session

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

// Query to fetch total amount of all withdrawals
$sqlTotal = "SELECT SUM(amount) AS total_amount FROM withdrawal";
$resultTotal = $conn->query($sqlTotal);

$totalAmount = 0;

if ($resultTotal->num_rows > 0) {
    $rowTotal = $resultTotal->fetch_assoc();
    $totalAmount = $rowTotal['total_amount'];
}

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query to fetch amount of pending withdrawals
$sqlPending = "SELECT SUM(amount) AS pending_amount FROM withdrawal 
               WHERE status = 'pending'";
$resultPending = $conn->query($sqlPending);

$pendingAmount = 0;

if ($resultPending->num_rows > 0) {
    $rowPending = $resultPending->fetch_assoc();
    $pendingAmount = $rowPending['pending_amount'];
}

// Query to fetch amount of completed withdrawals for the current month
$sqlCompleted = "SELECT SUM(amount) AS completed_amount FROM withdrawal 
                 WHERE status = 'completed' 
                 AND MONTH(withdrawal_date) = $currentMonth 
                 AND YEAR(withdrawal_date) = $currentYear";
$resultCompleted = $conn->query($sqlCompleted);

$completedAmount = 0;

if ($resultCompleted->num_rows > 0) {
    $rowCompleted = $resultCompleted->fetch_assoc();
    $completedAmount = $rowCompleted['completed_amount'];
}

// Query to fetch completed withdrawal amounts for each month
$sqlMonthlyCompleted = "SELECT MONTH(withdrawal_date) AS month, SUM(amount) AS amount 
                        FROM withdrawal 
                        WHERE status = 'completed' 
                        GROUP BY MONTH(withdrawal_date)";
$resultMonthlyCompleted = $conn->query($sqlMonthlyCompleted);

// Prepare data for the table
$tableData = [];
while ($row = $resultMonthlyCompleted->fetch_assoc()) {
    $tableData[$row['month']] = $row['amount'];
}

// Prepare data for the line chart
$chartData = [];
$chartLabels = [];
while ($row = $resultMonthlyCompleted->fetch_assoc()) {
    $chartLabels[] = date('F', mktime(0, 0, 0, $row['month'], 1));
    $chartData[] = $row['amount'];
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports</title>

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
        .container69 {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 3%;
            margin-top: 8%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-left: 10%;
        }

        .summary {
            margin-top: 20px;
            margin-left: 10%;
        }

        .summary p {
            margin: 10px 0;
        }

        .summary .amount {
            font-size: 1.2em;
            font-weight: bold;
        }

        table {
            margin-left: 10%;
            width: 80%;
            max-width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
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
                <a href="accountantHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Accountant Home</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="accountantReports.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Reports
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




    <div class="container69">
        <h2>Withdrawal Summary</h2>
        <div class="summary">
            <?php if ($totalAmount > 0): ?>
                <p>Total amount of all withdrawals: <span class="amount">$<?php echo number_format($totalAmount, 2); ?></span></p>
            <?php else: ?>
                <p>No withdrawals found.</p>
            <?php endif; ?>
            
            <?php if ($pendingAmount > 0): ?>
                <p>Amount of pending withdrawals: <span class="amount">$<?php echo number_format($pendingAmount, 2); ?></span></p>
            <?php else: ?>
                <p>No pending withdrawals found.</p>
            <?php endif; ?>
            
            <?php if ($completedAmount > 0): ?>
                <p>Amount of completed withdrawals for the current month: <span class="amount">$<?php echo number_format($completedAmount, 2); ?></span></p>
            <?php else: ?>
                <p>No completed withdrawals found for the current month.</p>
            <?php endif; ?>
        </div>

        <table>
            <caption style="margin-top: 10%; margin-bottom: 3%">Monthly Completed Withdrawals</caption>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Amount ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Initialize an array to hold monthly data with default amount as 0
                $defaultMonths = range(1, 12);
                $monthlyData = array_fill_keys($defaultMonths, 0);

                // Merge fetched data into the monthlyData array
                foreach ($tableData as $month => $amount) {
                    $monthlyData[$month] = $amount;
                }

                // Loop through all twelve months and display in the table
                foreach ($defaultMonths as $month) {
                    ?>
                    <tr>
                        <td><?php echo date('F', mktime(0, 0, 0, $month, 1)); ?></td>
                        <td><?php echo number_format($monthlyData[$month], 2); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>



    </div>













    <div><?php include 'footer.php'; ?></div>

    

</body>
</html>

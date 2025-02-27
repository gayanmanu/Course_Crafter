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
    <title>Home Page</title>
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
        
        .dashboard-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 80%;
            margin-left: 10%;
            margin-top: 5%;
        }
        .dashboard-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .dashboard-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 200px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .dashboard-box h2 {
            font-size: 24px;
            margin: 10px 0 0;
        }
        .dashboard-box p {
            font-size: 18px;
            margin: 10px 0 0;
        }
        .dashboard-box img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>


<body>
    <div class="content-overlay">
    <!-- Navigation Bar -->
    <div style="width:100%;">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #000000; width: 100%;">
            <li style="float: left; padding-left: 30px; height: 80px;">
                <a href="adminHome.php" style="display: block; height: 100%;">
                    <img src="logo-no-background.png" alt="Logo" style="height: 50px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="adminHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Home
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="adminDashboard.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Approve Courses</a>
            </li>


            <li style="float: left; padding-top: 20px;">
                <a href="addStaff.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Add Staff</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="approveLec.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Approve Lecturers</a>
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

<div class="dashboard-container">
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

    // Array of tables and labels
    $tables = [
        "users" => "Students",
        "teachers" => "Lecturers",
        "courses" => "Courses",
        "staff" => "Staff Members"
    ];

    // First row: Students, Lecturers, Courses, Staff Members
    echo '<div class="dashboard-row">';
    foreach ($tables as $table => $label) {
        $sql = "SELECT COUNT(*) as count FROM $table";
        $result = $conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            echo <<<HTML
            <div class="dashboard-box">
                <img src="counting.png" alt="Icon">
                <h2>{$row['count']}</h2>
                <p>$label</p>
            </div>
            HTML;
        } else {
            echo <<<HTML
            <div class="dashboard-box">
                <img src="counting.png" alt="Error Icon">
                <h2>Error</h2>
                <p>$label</p>
            </div>
            HTML;
        }
    }
    echo '</div>';

    // Calculate total income from coursepayment table
    $sqlTotalIncome = "SELECT SUM(courses.course_fee) as total_income 
                       FROM coursepayment 
                       JOIN courses ON coursepayment.course_id = courses.class_id";
    $resultTotalIncome = $conn->query($sqlTotalIncome);
    $totalIncome = $resultTotalIncome->fetch_assoc()['total_income'];

    // Calculate current month revenue from coursepayment table
    $currentMonth = date('Y-m');
    $sqlCurrentMonthRevenue = "SELECT SUM(courses.course_fee) as current_month_revenue 
                               FROM coursepayment 
                               JOIN courses ON coursepayment.course_id = courses.class_id 
                               WHERE DATE_FORMAT(coursepayment.payment_date, '%Y-%m') = '$currentMonth'";
    $resultCurrentMonthRevenue = $conn->query($sqlCurrentMonthRevenue);
    $currentMonthRevenue = $resultCurrentMonthRevenue->fetch_assoc()['current_month_revenue'];

    // Second row: Current Month Revenue, Total Income
    echo '<div class="dashboard-row">';
    // Display current month revenue
    echo <<<HTML
    <div class="dashboard-box">
        <img src="up-arrow.png" alt="Revenue Icon">
        <h2>\${$currentMonthRevenue}</h2>
        <p>Current Month Revenue</p>
    </div>
    HTML;

    // Display total income
    echo <<<HTML
    <div class="dashboard-box">
        <img src="up-arrow.png" alt="Income Icon">
        <h2>\${$totalIncome}</h2>
        <p>Total Income</p>
    </div>
    HTML;
    echo '</div>';

    $conn->close();
    ?>
</div>





    <div style="margin-top: 2%"><?php include 'footer.php'; ?></div>

    

</body>
</html>
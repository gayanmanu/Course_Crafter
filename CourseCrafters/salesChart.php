<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

    // Display the logged-in user's username
} else {
    // If the user is not logged in, redirect to login page
    header("Location: lecturerReg.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Chart</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <style>
        .chart-container {
            width: 50%;
            margin: 50px auto;
            text-align: center;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            flex-direction: column;
            align-items: center;
            background: url('cover.jpg') center center/cover no-repeat fixed;
        }
        .content-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1;
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
                <a href="withdrawal.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Withrawal</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="salesChart.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Sales Chart
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

    </div>


    <div class="chart-container">
        <h2 style="color: black;">Sales Chart</h2>
        <div id="salesChart"></div>
    </div>

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

    // Fetch classes related to the logged-in teacher's ID
    $sql = "SELECT courses.class_id, courses.course_name, courses.course_fee, COUNT(coursepayment.payment_id) as sales_count
            FROM courses
            LEFT JOIN coursepayment ON courses.class_id = coursepayment.course_id
            WHERE courses.teacher_id = '$teacher_id'
            GROUP BY courses.class_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $row['total_earned'] = $row['sales_count'] * $row['course_fee'];
            $data[] = $row;
        }
        echo '<script>';
        echo 'const salesData = ' . json_encode($data) . ';';
        echo 'const courseIds = salesData.map(entry => entry.class_id);';
        echo 'const courseNames = salesData.map(entry => entry.course_name);';
        echo 'const courseFees = salesData.map(entry => entry.course_fee);';
        echo 'const salesCounts = salesData.map(entry => entry.sales_count);';
        echo 'const totalEarned = salesData.map(entry => entry.total_earned);';
        echo '</script>';
    } else {
        echo '<script>const salesData = [];</script>';
    }

    $conn->close();
    ?>

    <script>
        if (salesData.length > 0) {
            const salesChart = document.getElementById('salesChart');
            Plotly.newPlot(salesChart, [{
                x: courseIds,
                y: salesCounts,
                text: courseNames.map((name, index) => `Course: ${name}<br>Price: RS:${courseFees[index]}<br>Sales: ${salesCounts[index]}<br>Total Earned: RS:${totalEarned[index]}`),
                type: 'bar'
            }], {
                title: 'Number of Sales per Course',
                xaxis: { title: 'Course ID', type: 'category' },
                yaxis: { title: 'Number of Sales' }
            });

            // Log the data in the console for verification
            console.log(courseIds, courseNames, courseFees, salesCounts, totalEarned);
        } else {
            document.getElementById('salesChart').innerText = 'No sales data available.';
        }
    </script>

        <div><?php include 'footer.php'; ?></div>
</body>
</html>

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
	<title>Admin Dashboard</title>
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
            margin-top: 5%;
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
        .pending-course-item form {
            text-align: center;
        }
        .pending-course-item input[type="submit"] {
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
            margin-top: 10px;
        }
        .pending-course-item input[type="submit"]:hover {
            background-color: #218838;
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
                <a href="adminHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Home</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="adminDashboard.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Approve Courses
                </a>
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





<div class="pending-course-container">
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

    // Fetch pending courses from the database with teacher names
    $sql = "SELECT courses.*, teachers.first_name, teachers.last_name
            FROM courses
            JOIN teachers ON courses.teacher_id = teachers.teacher_id
            WHERE courses.status = 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teacher_name = $row['first_name'] . ' ' . $row['last_name'];
            echo <<<HTML
                <a href="course_Reviewer.php?class_id={$row['class_id']}" class="pending-course-item">
                    <div>
                        <p><b>Class ID: {$row['class_id']}</b></p>
                        <p>Course Name: {$row['course_name']}</p>
                        <p>Teacher: {$teacher_name}</p>
                        <p>Location: {$row['location']}</p>
                        <p>Level: {$row['level']}</p>
                        <p>Description: {$row['description']}</p>
                        <p>Course Fee: {$row['course_fee']}</p>
                        <form action="approve_course.php" method="post">
                            <input type="hidden" name="class_id" value="{$row['class_id']}">
                            <input type="submit" name="approve" value="Approve">
                        </form>
                    </div>
                </a>
            HTML;
        }
    } else {
        echo "<p>No pending courses found.</p>";
    }

    $conn->close();
    ?>
</div>






<div style="margin-top: 15%"><?php include 'footer.php'; ?></div> 

    

</body>
</html>
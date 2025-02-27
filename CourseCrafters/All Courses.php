<?php
session_start(); 

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

} else {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>All Courses</title>
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


        .course-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-left: 50px;
            margin-right: 50px;
        }

        .course-item {
            width: 210px;
            height: 350px;
            border: 1px solid #ddd;
            margin: 20px;
            padding: 10px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 15px;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
            margin-top: 100px;
        }

        .course-item:hover {
            box-shadow: 0 50px 94px rgba(0, 0, 0, 0.3);
        }

        .course-item img {
            width: 200px;
            max-width: 100%;
            height: auto;
            border-radius: 15px 15px 0 0;
        }

    </style>
</head>


<body>
    <div class="content-overlay">
    <!-- Navigation Bar -->
    <div style="width:100%;">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #000000; width: 100%;">
            <li style="float: left; padding-left: 30px; height: 80px;">
                <a href="Dashboard.php" style="display: block; height: 100%;">
                    <img src="logo-no-background.png" alt="Logo" style="height: 50px; width: auto; padding: 20px;">
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="Dashboard.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Home</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="All Courses.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    All Courses
                </a>
            </li>

            <li style="float: left; padding-top: 20px;" id="categoryDropdown" onmouseover="showCategoryItems()" onmouseout="hideCategoryItems()">
                <a href="Category.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Category
                </a>
                <div id="categoryList" style="display: none; position: absolute; top: 80px; left: 300px; background-color: #333; border-radius: 10px; padding: 10px; width: 200px;height: 150px; box-sizing: border-box;">

                    <p>
                        <a href="Category.html" style="color:white; text-decoration: none;">Beginner Level</a>
                    </p>

                    <p>
                        <a href="Category.html" style="color:white; text-decoration: none;">Inermidiate Level</a>
                    </p>


                    <p>
                        <a href="Category.html" style="color:white; text-decoration: none;">Expert Level</a>
                    </p>
                </div>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="inquiry_form.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Inquiry</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="aboutUs.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">About US</a>
            </li>

            <li style="float: right; margin-right: 30px; margin-left: 30px; padding-top: 10px;">
                <a href="editProfile.php" style="display: block; color: white; text-align: center; text-decoration: none;">
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
                <a href="index.php" style="display: block; color: white; text-align: center; text-decoration: none;">
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




    <!-- Class Items -->
<div class="course-container">

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

    // Fetch existing courses from the database with teacher names excluding pending courses
    $sql = "SELECT courses.*, teachers.first_name, teachers.last_name
            FROM courses
            JOIN teachers ON courses.teacher_id = teachers.teacher_id
            WHERE courses.status != 'pending'";
    $result = $conn->query($sql);

    $counter = 0; // Initialize counter

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Increment counter
            $counter++;

            // Generate HTML for each course
            $teacher_name = $row['first_name'] . ' ' . $row['last_name'];
            $class_id = $row['class_id']; // Get the class ID
            echo <<<HTML
                <div class="course-item" onclick="redirectToCourse('$class_id')">
                    <p style="font-size: 10px; color: white; position: absolute; top: 130px; left: 18px;">
                        <b>Class ID : {$row['class_id']}</b>
                    </p>
                    <img src="classcover.jpg" alt="Class Cover Image" style="width:200px">
                    <p style="font-size: 10px; color: white; position: absolute; top: 130px; right: 18px;">
                        <b>Teacher ID : {$row['teacher_id']}</b>
                    </p>
                    <div style="text-align: left; padding: 10px; flex-grow: 1; z-index: 1; position: relative;">
                        <h2 style="margin: 0; color: black;">{$row['course_name']}</h2>
                        <h3 style="margin: 0; color: black;">Teacher: {$teacher_name}</h3>
                        <p style="margin: 0; color: black;">Location: {$row['location']}</p>
                        <p style="margin: 0; color: black; font-size: 13px;">{$row['level']}</p>
                        <p style="margin: 0; color: black; font-size: 10px;">{$row['description']}</p>
                        <p style="margin: 0; color: black; font-size: 15px;">$ {$row['course_fee']}</p>
                    </div>
                </div>
            HTML;

            // Check if the counter reaches five
            if ($counter == 6) {
                echo '</div><div class="course-container">';
                $counter = 0; // Reset counter
            }
        }
    } else {
        echo "<p>No courses found.</p>";
    }

    $conn->close();
    ?>

</div>

    <script>
        // JavaScript function as defined above
        function redirectToCourse(courseId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    window.location.href = `singleCourse.php?course_id=${courseId}`;
                }
            };
            xhttp.open("POST", "save_course_id.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("course_id=" + courseId);
        }
    </script>



    <?php include 'footer.php'; ?>

    

</body>
</html>
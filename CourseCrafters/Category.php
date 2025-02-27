<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

} else {
    // If user is not logged in, redirect to login page
    header("Location: index.php");
    exit();
}


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

    // Query to fetch courses for the logged-in teacher
    $sql = "SELECT class_id, course_name, location, description, course_fee, status, level FROM courses WHERE status='approved' ORDER BY level, course_name";
    $result = $conn->query($sql);

    // Initialize arrays to categorize courses by level
    $beginnerCourses = [];
    $intermediateCourses = [];
    $expertCourses = [];

    if ($result->num_rows > 0) {
        // Loop through each course and categorize it by level
        while ($row = $result->fetch_assoc()) {
            switch ($row['level']) {
                case 'Beginner Level':
                    $beginnerCourses[] = $row;
                    break;
                case 'Intermediate Level':
                    $intermediateCourses[] = $row;
                    break;
                case 'Expert Level':
                    $expertCourses[] = $row;
                    break;
            }
        }
    } else {
        echo "No courses found.";
    }

    $conn->close();


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Category</title>
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
        .content-container {
            width: 95%;
            padding: 20px;
            margin: 0px auto;
            border-radius: 10px;
        }

        .level-section {
            margin-bottom: 40px;
        }

        .level-section h2 {
            border-bottom: 2px solid #45a049;
            padding-bottom: 10px;
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
            margin-top: 50px;
        }

        .course-item:hover {
            box-shadow: 0 50px 94px rgba(0, 0, 0, 0.3);
        }

        .course-item img {
            width: 200px;
            max-width: 100%;
            height: auto;
            border-radius: 15px 15px 0 0; /* Rounded corners only at the top */
        }

        .course-details {
            padding: 10px;
            text-align: left;
        }

        .course-details p {
            margin: 5px 0;
            font-size: 14px;
            color: black;
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
                <a href="All Courses.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">All Courses</a>
            </li>

            <li style="float: left; padding-top: 20px;" id="categoryDropdown" onmouseover="showCategoryItems()" onmouseout="hideCategoryItems()">
                <a class="active" href="Category.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Category
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

    <div class="content-container">
        <div class="level-section">
            <h2>Beginner Level</h2>
            <div class="course-container">
                <?php foreach ($beginnerCourses as $course): ?>
                    <div class="course-item" onclick="redirectToCourse('<?php echo $course['class_id']; ?>')">
                        <img src="classcover.jpg" alt="Course Image">
                        <div class="course-details">
                            <p><strong>Course ID:</strong> <?php echo $course['class_id']; ?></p>
                            <p><strong>Course Name:</strong> <?php echo $course['course_name']; ?></p>
                            <p><strong>Location:</strong> <?php echo $course['location']; ?></p>
                            <p><strong>Description:</strong> <?php echo $course['description']; ?></p>
                            <p><strong>Course Fee:</strong> $<?php echo number_format($course['course_fee'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="level-section">
            <h2>Intermediate Level</h2>
            <div class="course-container">
                <?php foreach ($intermediateCourses as $course): ?>
                    <div class="course-item" onclick="redirectToCourse('<?php echo $course['class_id']; ?>')">
                        <img src="classcover.jpg" alt="Course Image">
                        <div class="course-details">
                            <p><strong>Course ID:</strong> <?php echo $course['class_id']; ?></p>
                            <p><strong>Course Name:</strong> <?php echo $course['course_name']; ?></p>
                            <p><strong>Location:</strong> <?php echo $course['location']; ?></p>
                            <p><strong>Description:</strong> <?php echo $course['description']; ?></p>
                            <p><strong>Course Fee:</strong> $<?php echo number_format($course['course_fee'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="level-section">
            <h2>Expert Level</h2>
            <div class="course-container">
                <?php foreach ($expertCourses as $course): ?>
                    <div class="course-item" onclick="redirectToCourse('<?php echo $course['class_id']; ?>')">
                        <img src="classcover.jpg" alt="Course Image">
                        <div class="course-details">
                            <p><strong>Course ID:</strong> <?php echo $course['class_id']; ?></p>
                            <p><strong>Course Name:</strong> <?php echo $course['course_name']; ?></p>
                            <p><strong>Location:</strong> <?php echo $course['location']; ?></p>
                            <p><strong>Description:</strong> <?php echo $course['description']; ?></p>
                            <p><strong>Course Fee:</strong> $<?php echo number_format($course['course_fee'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script>
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


<div><?php include 'footer.php'; ?></div>


</body>
</html>
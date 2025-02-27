<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

} else {
    // If user is not logged in, redirect to login page
    header("Location: lecturerReg.php");
    exit();
}

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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $course_name = $_POST['course_name'];
    $location = $_POST['location'];
    $fee = $_POST['fee'];
    $level = $_POST['level'];
    $description = $_POST['description'];
    $status = 'pending'; // Default status for new courses

    if (isset($_POST['add'])) {
        // Insert data into the "courses" table
        $insert_sql = "INSERT INTO courses (class_id, teacher_id, course_name, location, description, level, course_fee, status) VALUES ('$class_id', '$teacher_id', '$course_name', '$location', '$description', '$level', '$fee', '$status')";

        if ($conn->query($insert_sql) === TRUE) {
            echo '<script>alert("New course added successfully."); window.location.href="LecDashboard.php";</script>';
        } else {
            echo '<script>alert("Error: ' . $conn->error . '"); window.history.back();</script>';
        }
    } elseif (isset($_POST['remove'])) {
        // Delete data from the "courses" table
        $delete_sql = "DELETE FROM courses WHERE class_id = '$class_id' AND teacher_id = '$teacher_id'";

        if ($conn->query($delete_sql) === TRUE) {
            echo '<script>alert("Course removed successfully."); window.location.href="LecDashboard.php";</script>';
        } else {
            echo '<script>alert("Error: ' . $conn->error . '"); window.history.back();</script>';
        }
    } elseif (isset($_POST['edit'])) {
        // Update data in the "courses" table
        $update_sql = "UPDATE courses SET course_name = '$course_name', location = '$location', description = '$description', level = '$level', course_fee = '$fee', status = '$status' WHERE class_id = '$class_id' AND teacher_id = '$teacher_id'";

        if ($conn->query($update_sql) === TRUE) {
            echo '<script>alert("Course updated successfully."); window.location.href="LecDashboard.php";</script>';
        } else {
            echo '<script>alert("Error: ' . $conn->error . '"); window.history.back();</script>';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
    <style>
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
            
            height: auto;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

        .form-container,
        .course-container {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 18%;
            margin-left: 39%;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .course-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .course-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            box-sizing: border-box;
            position: relative;
            text-align: left;
        }
        .course-item h2 {
            margin-top: 0;
            color: #333;
        }
        .course-item p {
            margin: 10px 0;
            color: #555;
        }
        .course-item .insert-btn {
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            padding: 10px 20px;
            margin-top: 10px;
            display: block;
            width: 100%;
            text-align: center;
        }
        .course-item .insert-btn:hover {
            background-color: #218838;
        }

        .course-item.selected {
            border: 2px solid #4CAF50;
        }
    </style>
</head>
<body>
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
                <a class="active" href="LecDashboard.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Add Courses
                </a>
            </li>


            <li style="float: left; padding-top: 20px;">
                <a href="withdrawal.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Withrawal</a>
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

    </div>

    <div class="form-container">
        <h2 style="text-align:center;">Add New Course</h2>
        <form action="" method="post">
            <input type="text" name="class_id" id="class_id" hidden>

            <label for="teacher_id">Teacher ID:</label>
            <input type="text" name="teacher_id" id="teacher_id" value="<?php echo $teacher_id; ?>" readonly required>

            <label for="course_name">Course Name:</label>
            <input type="text" name="course_name" id="course_name" required>

            <label for="location">Location:</label>
            <input type="text" name="location" id="location" required>

            <label for="fee">Course Fee:</label>
            <input type="number" name="fee" id="fee" required>

            <label for="level">Level:</label>
            <select name="level" id="level" required>
                <option value="Beginner Level">Beginner Level</option>
                <option value="Intermediate Level">Intermediate Level</option>
                <option value="Expert Level">Expert Level</option>
            </select>


            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>

            <input type="submit" name="add" value="Add Course">
            <input type="submit" name="remove" value="Remove Course">
            <input type="submit" name="edit" value="Edit Course">
        </form>
    </div>



    <div class="course-container">
        <?php
        // Reconnect to the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the logged-in teacher's ID

        if(isset($_SESSION['teacher_id'])) {
            $teacher_id = $_SESSION['teacher_id'];

            // Fetch courses of the logged-in teacher
            $sql = "SELECT courses.*, teachers.first_name, teachers.last_name
                    FROM courses
                    JOIN teachers ON courses.teacher_id = teachers.teacher_id
                    WHERE courses.teacher_id = '$teacher_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Generate HTML for each course
                    $teacher_name = $row['first_name'] . ' ' . $row['last_name'];
                    echo <<<HTML
                        <div class="course-item" data-course-id="{$row['class_id']}">
                            <h2>{$row['course_name']}</h2>
                            <p>Teacher: {$teacher_name}</p>
                            <p>Location: {$row['location']}</p>
                            <p>Course Fee: {$row['course_fee']}</p>
                            <p>Description: {$row['description']}</p>
                            <p>Class ID: {$row['class_id']}</p>
                            <p>Level: {$row['level']}</p>
                            <p>Teacher ID: {$row['teacher_id']}</p>
                            <p>Status: {$row['status']}</p>
                            <button type="button" class="insert-btn">Insert</button>
                        </div>
                    HTML;
                }
            } else {
                echo "<p>No courses found for the logged-in teacher.</p>";
            }
        } else {
            echo "<p>Teacher ID not found.</p>";
        }

        $conn->close();
        ?>
    </div>


    <script>
        // Add click event listener to each insert button
        document.querySelectorAll('.insert-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                // Retrieve the course ID from the parent course-item
                const courseId = this.parentNode.getAttribute('data-course-id');

                // Redirect to content.php with the course ID as a parameter
                window.location.href = `content.php?course_id=${courseId}`;
            });
        });
    </script>

    <script>
        // Add click event listener to each course item
        document.querySelectorAll('.course-item').forEach(item => {
            item.addEventListener('click', function () {
                // Remove the 'selected' class from all course items
                document.querySelectorAll('.course-item').forEach(item => {
                    item.classList.remove('selected');
                });

                // Add the 'selected' class to the clicked course item
                this.classList.add('selected');

                // Retrieve course information from the clicked item
                const courseId = this.getAttribute('data-course-id');
                const courseName = this.querySelector('h2').textContent;
                const teacherName = this.querySelector('p:nth-child(2)').textContent.replace('Teacher: ', '');
                const location = this.querySelector('p:nth-child(3)').textContent.replace('Location: ', '');
                
                // Updated the index to correctly select course fee and description
                const fee = this.querySelector('p:nth-child(4)').textContent.replace('Course Fee: ', '');
                const description = this.querySelector('p:nth-child(5)').textContent.replace('Description: ', '');

                // Set the form fields with the retrieved information
                document.getElementById('class_id').value = courseId;
                document.getElementById('course_name').value = courseName;
                document.getElementById('location').value = location;
                document.getElementById('description').value = description;
                document.getElementById('fee').value = fee;
            });
        });
    </script>



    <div><?php include 'footer.php'; ?></div>
</div>


</body>
</html>




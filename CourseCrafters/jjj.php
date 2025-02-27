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

// Fetch existing teacher IDs from the "teachers" table in ascending order
$teachers_sql = "SELECT teacher_id FROM teachers ORDER BY teacher_id ASC";
$teachers_result = $conn->query($teachers_sql);

// Check if there are existing teachers
if ($teachers_result->num_rows > 0) {
    // Store existing teacher IDs in an array
    $teacher_ids = [];
    while ($teacher_row = $teachers_result->fetch_assoc()) {
        $teacher_ids[] = $teacher_row['teacher_id'];
    }
} else {
    echo "No teachers found. Add teachers before adding courses.";
    exit; // Stop execution if there are no teachers
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $course_name = $_POST['course_name'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Insert data into the "courses" table
    $insert_sql = "INSERT INTO courses (class_id, teacher_id, course_name, location, description) VALUES ('$class_id', '$teacher_id', '$course_name', '$location', '$description')";

    // Check if the query was successful
    if ($conn->query($insert_sql) === TRUE) {
        echo '<script>alert("New course added successfully."); window.history.back();</script>';
    } else {
        echo '<script>alert("Error: ' . $conn->error . '"); window.history.back();</script>';
    }
}

// Close the database connection
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
        }

        form-container,
        .course-container {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
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
            justify-content: center;
        }

        .course-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            text-align: left;
            width: 300px;
            cursor: pointer; /* Add cursor pointer for better user experience */
        }

        .course-item.selected {
            border: 2px solid #4CAF50;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 style="text-align:center;">Add New Course</h2>
        <form action="" method="post">
            <label for="class_id">Class ID:</label>
            <input type="text" name="class_id" id="class_id" required>

            <label for="teacher_id">Teacher ID:</label>
            <select name="teacher_id" id="teacher_id" required>
                <?php
                // Populate dropdown list with existing teacher IDs
                foreach ($teacher_ids as $teacher) {
                    echo "<option value='$teacher'>$teacher</option>";
                }
                ?>
            </select>

            <label for="course_name">Course Name:</label>
            <input type="text" name="course_name" id="course_name" required>

            <label for="location">Location:</label>
            <input type="text" name="location" id="location" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>

            <input type="submit" name="submit" value="Add Course">
        </form>
    </div>


    <!-- Bar Chart -->
    <div style="width:25%; margin: 50px; text-align: center;">
        <h2>Sales Chart</h2>
        <div id="salesChart"></div>
    </div>

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

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

    // Fetch sales data from the database
    $sql = "SELECT coursepayment.course_id, courses.course_name, courses.courseFee, COUNT(coursepayment.payment_id) as sales_count
            FROM coursepayment
            LEFT JOIN courses ON courses.class_id = coursepayment.course_id
            GROUP BY coursepayment.course_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $row['total_earned'] = $row['sales_count'] * $row['courseFee'];
            $data[] = $row;
        }
        echo '<script>';
        echo 'const salesData = ' . json_encode($data) . ';';
        echo 'const courseIds = salesData.map(entry => entry.course_id);';
        echo 'const courseNames = salesData.map(entry => entry.course_name);';
        echo 'const courseFees = salesData.map(entry => entry.courseFee);';
        echo 'const salesCounts = salesData.map(entry => entry.sales_count);';
        echo 'const totalEarned = salesData.map(entry => entry.total_earned);';
        echo '</script>';
    } else {
        echo '<script>const salesData = [];</script>';
    }

    $conn->close();
    ?>

    <script>
        // Create a bar chart
        const salesChart = document.getElementById('salesChart');
        Plotly.newPlot(salesChart, [{
            x: courseIds,
            y: salesCounts,
            text: courseNames.map((name, index) => `Course: ${name}<br>Price: RS:${courseFees[index]}<br>Sales: ${salesCounts[index]}<br>Total Earned: RS:${totalEarned[index]}`),
            type: 'bar'
        }], {
            title: 'Number of Sales per Course'
        });

        // Log the data in the console for verification
        console.log(courseIds, courseNames, courseFees, salesCounts, totalEarned);
    </script>



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

    // Fetch existing courses from the database with teacher names
    $sql = "SELECT courses.*, teachers.first_name, teachers.last_name
            FROM courses
            JOIN teachers ON courses.teacher_id = teachers.teacher_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Generate HTML for each course with a unique data-course-id attribute
            $teacher_name = $row['first_name'] . ' ' . $row['last_name'];
            echo <<<HTML
                <div class="course-item" data-course-id="{$row['class_id']}">
                    <h2>{$row['course_name']}</h2>
                    <p>Teacher: {$teacher_name}</p>
                    <p>Location: {$row['location']}</p>
                    <p>Description: {$row['description']}</p>
                    <p>Class ID: {$row['class_id']}</p>
                    <p>Teacher ID: {$row['teacher_id']}</p>
                    <button type="button" class="insert-btn">Insert</button>
                </div>
            HTML;
        }
    } else {
        echo "<p>No courses found.</p>";
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
                const description = this.querySelector('p:nth-child(4)').textContent.replace('Description: ', '');

                // Set the form fields with the retrieved information
                document.getElementById('class_id').value = courseId;
                document.getElementById('course_name').value = courseName;
                document.getElementById('teacher_id').value = teacherName; // Update this line if teacher_id is not the teacher name
                document.getElementById('location').value = location;
                document.getElementById('description').value = description;
            });
        });
    </script>



    
</body>

</html>





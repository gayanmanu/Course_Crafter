<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CourseCraftersDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
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

// Handle update button click
if (isset($_POST['update'])) {
    // Retrieve form data
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $course_name = $_POST['course_name'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Generate course link
    $course_link = str_replace(' ', '_', $course_name) . ".php";

    // Update data in the "courses" table
    $update_sql = "UPDATE courses SET teacher_id='$teacher_id', course_name='$course_name', location='$location', description='$description', course_link='$course_link' WHERE class_id='$class_id'";

    // Check if the query was successful
    if ($conn->query($update_sql) === TRUE) {
        echo "Course updated successfully.";
    } else {
        echo "Error updating course: " . $conn->error;
    }
}

// Handle remove button click
if (isset($_POST['remove'])) {
    // Retrieve form data
    $class_id = $_POST['class_id'];

    // Delete data from the "courses" table
    $delete_sql = "DELETE FROM courses WHERE class_id = '$class_id'";

    // Check if the query was successful
    if ($conn->query($delete_sql) === TRUE) {
        echo "Course removed successfully.";
    } else {
        echo "Error removing course: " . $conn->error;
    }
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $course_name = $_POST['course_name'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Generate course link
    $course_link = str_replace(' ', '_', $course_name) . ".php";

    // Insert data into the "courses" table
    $insert_sql = "INSERT INTO courses (class_id, teacher_id, course_name, location, description, course_link) VALUES ('$class_id', '$teacher_id', '$course_name', '$location', '$description', '$course_link')";

    

    // Check if the query was successful
    if ($conn->query($insert_sql) === TRUE) {
        

        // Create a file based on the course name
        $filename = "C:/xampp/htdocs/CourseCrafters/" . str_replace(' ', '_', $course_name) . ".php";
        $file_content = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>$course_name</title>
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


        .main-topic {
            width: 90%;
            height: 65px;
            background-color: rgba(255, 255, 255, 0.7);
            color: black;
            border: none;
            text-align: left;
            text-decoration: none;
            display: inline-block;
            font-size: 30px;
            cursor: pointer;
            margin: 5px;
            margin-bottom: 20px;
            text-align: center;
            padding-top: 20px;
        }


        .main-topic-button {
            width: 90%;
            height: 50px;
            background-color: #4CAF50;
            color: white;
            border: none;
            text-align: left;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
        }

        .sub-topic-list {
            list-style-type: none;
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .visible-sub-topic {
            max-height: 1000px; /* Adjust this value based on your content height */
            transition: max-height 0.1s ease-in;
            background-color: rgba(255, 255, 255, 0.7);
            width: 80%;
            margin-left: 30px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 30px;
            padding-top: 30px;
            border-radius: 30px;
        }

        .show-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-top: 5px;
            cursor: pointer;
        }

    </style>
</head>

<body>
    <?php include 'navigation.php'; ?>

    <!-- Your HTML code here -->

    <?php include 'footer.php'; ?>
</body>
</html>
HTML;

        file_put_contents($filename, $file_content);

        
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
    <style>
        .course-item.selected {
            border: 2px solid #4CAF50;
        }
    </style>

</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; display: flex; min-height: 100vh; flex-direction: column;">

    <div style="display: flex; justify-content: space-between; margin-top: 50px;">
        <!-- Form for Course Add --> 
        <div class="form-container" style="text-align: left; margin-bottom: 20px; margin-left: 25%;width: 50%;">
            <form action="" method="post" style="background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; width: 300px; text-align: center; margin-bottom: 20px;">
                <h2 style="text-align:center;">Add New Course</h2>
                <label for="class_id" style="display: block; margin: 10px 0;">Class ID:</label>
                <input type="text" name="class_id" id="class_id" required style="width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box;">

                <label for="teacher_id" style="display: block; margin: 10px 0;">Teacher ID:</label>
                <select name="teacher_id" id="teacher_id" required style="width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box;">
                    <?php
                    // Populate dropdown list with existing teacher IDs
                    foreach ($teacher_ids as $teacher) {
                        echo "<option value='$teacher'>$teacher</option>";
                    }
                    ?>
                </select>

                <label for="course_name" style="display: block; margin: 10px 0;">Course Name:</label>
                <input type="text" name="course_name" id="course_name" required style="width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box;">

                <label for="location" style="display: block; margin: 10px 0;">Location:</label>
                <input type="text" name="location" id="location" required style="width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box;">

                <label for="description" style="display: block; margin: 10px 0;">Description:</label>
                <textarea name="description" id="description" rows="4" required style="width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box; resize: vertical;"></textarea>

                <input type="submit" name="submit" value="Add Course" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer;border-radius: 10px;">
                <input type="submit" name="update" value="Update Course" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer;border-radius: 10px;">
                <input type="submit" name="remove" value="Remove Course" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer; margin-top: 10px;border-radius: 10px;">
            </form>
        </div>

        <!-- Bar Chart -->
        <div style="width:50%; margin: 50px; text-align: right; margin-right: 25%;">
            <div id="salesChart"></div>
        </div>
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


    <!-- Display Courses -->
    <div class="course-container" style="display: flex; flex-wrap: wrap; justify-content: center;">

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

        $count = 0; // Counter for items in a row

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Generate HTML for each course with a unique data-course-id attribute
                $teacher_name = $row['first_name'] . ' ' . $row['last_name'];

                // Start a new row after every five items
                if ($count % 5 == 0) {
                    echo '</div><div class="course-container" style="display: flex; flex-wrap: wrap; justify-content: center;">';
                }
        ?>
                <div class="course-item" data-course-id="<?php echo $row['class_id']; ?>" style="background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; margin: 10px; text-align: left; width: 300px; cursor: pointer;  margin-bottom: 50px;">
                    <h2><?php echo $row['course_name']; ?></h2>
                    <p>Teacher: <?php echo $teacher_name; ?></p>
                    <p>Location: <?php echo $row['location']; ?></p>
                    <p>Description: <?php echo $row['description']; ?></p>
                    <p>Class ID: <?php echo $row['class_id']; ?></p>
                    <p>Teacher ID: <?php echo $row['teacher_id']; ?></p>
                </div>
        <?php
                $count++;
            }
        } else {
            echo "<p>No courses found.</p>";
        }

        $conn->close();
        ?>
    </div>


    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <script>
        // Create a bar chart
        const salesChart = document.getElementById('salesChart');
        Plotly.newPlot(salesChart, [{
            x: courseIds,
            y: salesCounts,
            text: courseNames.map((name, index) => `Course: ${name}<br>Price: RS:${courseFees[index]}<br>Sales: ${salesCounts[index]}<br>Total Earned: RS:${totalEarned[index]}`),
            type: 'bar'
        }], {
            title: 'Number of Sales per Course',
            xaxis: {
                type: 'category'
            },
            bargap: 0.1, // Adjust the gap between bars
            bargroupgap: 0.2 // Adjust the gap between groups of bars
        });

        // Log the data in the console for verification
        console.log(courseIds, courseNames, courseFees, salesCounts, totalEarned);


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

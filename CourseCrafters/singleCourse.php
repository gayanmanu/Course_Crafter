<?php
session_start();

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

// Check if the course ID is provided in the URL query parameters
if (isset($_GET['course_id'])) {
    // Retrieve the course ID from the URL
    $course_id = $_GET['course_id'];
} else {
    // If course ID is not provided, display an error message
    die("Course ID not provided in the URL.");
}

// Get user ID from session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // If user is not logged in, redirect to login page
    header('Location: register.php');
    exit();
}

// Check if the user has paid for the course
$payment_check_sql = "SELECT * FROM coursepayment WHERE user_id = '$user_id' AND course_id = '$course_id'";
$payment_result = $conn->query($payment_check_sql);
if ($payment_result->num_rows == 0) {
    $has_paid = false;
} else {
    $has_paid = true;
}

// Fetch course details
$sql = "SELECT * FROM courses WHERE class_id = '$course_id'";
$course_result = $conn->query($sql);
if ($course_result->num_rows == 0) {
    die("Course not found.");
}
$course = $course_result->fetch_assoc();

// Fetch main topics and their sub-topics
$sql = "
    SELECT 
        mt.main_topic_id, mt.name AS main_topic_name, 
        st.sub_topic_id, st.name AS sub_topic_name, 
        st.video_link, st.word_file_link, st.exam_link, st.description
    FROM main_topics mt
    LEFT JOIN sub_topics st ON mt.main_topic_id = st.main_topic_id
    WHERE mt.class_id = '$course_id'
    ORDER BY mt.main_topic_id, st.sub_topic_id";
$result = $conn->query($sql);

$topics = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $main_topic_id = $row['main_topic_id'];
        if (!isset($topics[$main_topic_id])) {
            $topics[$main_topic_id] = [
                'name' => $row['main_topic_name'],
                'sub_topics' => []
            ];
        }
        if ($row['sub_topic_id']) {
            $topics[$main_topic_id]['sub_topics'][] = [
                'name' => $row['sub_topic_name'],
                'video_link' => $row['video_link'],
                'word_file_link' => $row['word_file_link'],
                'exam_link' => $row['exam_link'],
                'description' => $row['description']
            ];
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
    <title>View Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
        .container {
            width: 62%;
            margin: 0 auto;
            display: none;
            margin-bottom: 5%;
        }
        .main-topic {
            margin-bottom: 20px;
            background-color: black;
            border: none;
            border-radius: 5px;
            padding: 10px;
            padding-left: 20px;
            color: white;
        }
        .sub-topics-container {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 5px;
            color: black;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .sub-topic {
            margin-top: 10px;
        }
        .icon {
            width: 32px;
            height: 32px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .main-topic h2 {
            cursor: pointer;
        }
        .sub-topic-icons {
            display: flex;
            align-items: center;
        }
        .sub-topic-icons a {
            margin-right: 10px;
        }

        .container22 {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            margin-top: 50px;

        }
        .feedback-form, .feedback-list {
            margin-top: 20px;
        }
        .feedback-form input, .feedback-form textarea {
            display: block;
            width: 98%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .feedback-form button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .feedback-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .feedback-list {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow-y: auto; /* Ensure scrollbars are visible only when needed */
            max-height: 300px; /* Limit the maximum height of the feedback list */
        }


        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: center;
            border-radius: 10px;
        }
        .popup button {
            margin-top: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
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



    <div class="popup-overlay" id="popup-overlay"></div>
    <div class="popup" id="payment-popup">
        <h2>Payment Required <i class="fas fa-lock"></i> </h2>
        <p>You need to pay for this course to access the content.</p>
        <button onclick="paymentGateway('<?php echo $course_id; ?>');">Pay Here</button>


        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
<script>
function paymentGateway(courseId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if(xhttp.readyState == 4 && xhttp.status == 200){
            var obj = JSON.parse(xhttp.responseText);
            
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);

                // Send request to paymentNotification.php to insert payment record
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "paymentNotification.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                    }
                };
                xhr.send("status=SUCCESS");
            };
            
            // Payment window close
            payhere.onDismissed = function onDismissed() {
                console.log("Payment dismissed");
            };
            
            // Error occurred
            payhere.onError = function onError(error) {
                console.log("Error:" + error);
            };
            
            // Put the payment variables here
            var payment = {
                "sandbox": true,
                "merchant_id": "1226143",    // Replace with your Merchant ID
                "return_url": "http://localhost/PayHere/",     // Important
                "cancel_url": "http://localhost/PayHere/",     // Important
                "notify_url": "http://sample.com/notify",
                "order_id": obj["order_id"],
                "items": "Course",
                "amount": obj["amount"],
                "currency": obj["currency"],
                "hash": obj["hash"], // Replace with generated hash retrieved from backend
                "first_name": "Saman",
                "last_name": "Perera",
                "email": "samanp@gmail.com",
                "phone": "0771234567",
                "address": "No.1, Galle Road",
                "city": "Colombo",
                "country": "Sri Lanka",
                "delivery_address": "No. 46, Galle road, Kalutara South",
                "delivery_city": "Kalutara",
                "delivery_country": "Sri Lanka",
                "custom_1": "",
                "custom_2": ""
            };
            
            payhere.startPayment(payment);
        }
    }
    xhttp.open("GET", `payhereprocess.php?course_id=${courseId}`, true);
    xhttp.send();
}
</script>


     
    </div>



    <div class="container" id="course-container">
        <h1><?php echo htmlspecialchars($course['course_name']); ?></h1>

        <div id="course-content">
            <?php foreach ($topics as $main_topic_id => $main_topic): ?>
                <div class="main-topic">
                    <h2 onclick="toggleSubTopics('<?php echo $main_topic_id; ?>')"><?php echo htmlspecialchars($main_topic['name']); ?></h2>
                    <div class="sub-topics-container" id="sub-topics-<?php echo $main_topic_id; ?>">
                        <?php foreach ($main_topic['sub_topics'] as $sub_topic): ?>
                            <div class="sub-topic">
                                <h3><?php echo htmlspecialchars($sub_topic['name']); ?></h3>
                                <p><?php echo nl2br(htmlspecialchars($sub_topic['description'])); ?></p>
                                <div class="sub-topic-icons">
                                    <?php if ($sub_topic['video_link']): ?>
                                        <a href="<?php echo htmlspecialchars($sub_topic['video_link']); ?>" target="_blank">
                                            <img src="video1.png" alt="Video Icon" class="icon">
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($sub_topic['word_file_link']): ?>
                                        <a href="<?php echo htmlspecialchars($sub_topic['word_file_link']); ?>" target="_blank">
                                            <img src="pdf.png" alt="PDF Icon" class="icon">
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($sub_topic['exam_link']): ?>
                                        <a href="<?php echo htmlspecialchars($sub_topic['exam_link']); ?>" target="_blank">
                                            <img src="exam.png" alt="Quiz Icon" class="icon">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function toggleSubTopics(topicId) {
            var container = document.getElementById('sub-topics-' + topicId);
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var hasPaid = <?php echo json_encode($has_paid); ?>;
            if (!hasPaid) {
                document.getElementById('popup-overlay').style.display = 'block';
                document.getElementById('payment-popup').style.display = 'block';
            } else {
                document.getElementById('course-container').style.display = 'block';
            }
        });
    </script>
    <?php
$course_id = $_GET['course_id'];
?>

    <div class="container22">
        <h1>Course Feedback</h1>

<!-- Feedback Form -->
<div class="feedback-form">
    <h2>Submit Feedback</h2>
    <form id="feedbackForm" method="POST" action="feedback.php">
        <!-- Hidden input field to store the course ID -->
        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">

        <label for="rating">Rating:</label>
        <input type="number" name="rating" min="1" max="5" required>
        <label for="feedback">Feedback:</label>
        <textarea name="feedback" required></textarea>
        <button type="submit">Submit</button>
    </form>
</div>


        <!-- Display Feedback -->
        <div class="feedback-list">
            <h2>Feedback</h2>
            <div id="feedbackContainer">
                <!-- Feedback items will be loaded here via AJAX -->
            </div>
        </div>
    </div>


<script>
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('feedback.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            loadFeedback();
            this.reset();
        })
        .catch(error => console.error('Error:', error));
    });

function loadFeedback() {
    fetch('feedback.php?course_id=<?php echo $course_id; ?>') // Set the course ID dynamically
        .then(response => response.json())
        .then(data => {
            const feedbackContainer = document.getElementById('feedbackContainer');
            feedbackContainer.innerHTML = '';
            data.forEach(feedback => {
                const feedbackItem = document.createElement('div');
                feedbackItem.className = 'feedback-item';
                feedbackItem.innerHTML = `
                    <p><strong>Rating:</strong> ${feedback.rating}</p>
                    <p><strong>Feedback:</strong> ${feedback.feedback}</p>
                    <p><strong>User Email:</strong> ${feedback.email}</p>
                    <p><strong>Created At:</strong> ${feedback.created_at}</p>
                    ${feedback.reply ? `<p><strong>Reply:</strong> ${feedback.reply}</p>` : ''}
                `;
                feedbackContainer.appendChild(feedbackItem);
            });
        })
        .catch(error => console.error('Error:', error));
}


    // Load feedback when the page loads
    window.onload = function() {
        var hasPaid = <?php echo json_encode($has_paid); ?>;
        if (!hasPaid) {
            document.getElementById('popup-overlay').style.display = 'block';
            document.getElementById('payment-popup').style.display = 'block';
            document.getElementById('feedback-form').style.display = 'none';
            document.getElementById('feedback-list').style.display = 'none';
            document.getElementById('course-container').style.display = 'none';
            document.getElementById('container22').style.display = 'none'; // Hide container22
        } else {
            loadFeedback();
        }
    };
</script>


</body>
<footer style="margin-top: 20%"><?php include 'footer.php'; ?></footer>
</html>

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
if (isset($_GET['class_id'])) {
    // Retrieve the course ID from the URL
    $course_id = $_GET['class_id'];
} else {
    // If course ID is not provided, display an error message
    die("Course ID not provided in the URL.");
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
    <title>View Course for Course Reviewer</title>
    <!-- Add your CSS and JavaScript links here -->
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: url('cover.jpg') center center/cover no-repeat fixed;
    }
    .container {
        width: 60%;
        margin: 0 auto;
    }
    .main-topic {
        margin-bottom: 20px;
        background-color: #f4f4f4;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }
    .sub-topics-container {
        display: none;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.7);
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
    .back-button {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #ff0000;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
    }
    .back-button:hover {
        background-color: #cc0000;
    }
</style>

<body>
    <a href="javascript:history.back()" class="back-button">Back</a>

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
    </script>
</body>
</html>


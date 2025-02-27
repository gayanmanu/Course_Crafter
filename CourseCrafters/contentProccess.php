<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CourseCraftersDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$course_id = $_POST['class_id'] ?? null;
if (!$course_id) {
    die("Class ID is not set.");
}

$main_topics = [];
foreach ($_POST as $key => $value) {
    if (strpos($key, 'main_topic_') === 0) {
        $main_topics[] = [
            'id' => substr($key, 11),
            'name' => $value,
            'sub_topics' => []
        ];
    }
}

foreach ($main_topics as &$main_topic) {
    $main_topic_id = $main_topic['id'];
    foreach ($_POST as $key => $value) {
        if (strpos($key, "sub_topic_{$main_topic_id}_") === 0) {
            $sub_topic_id = substr($key, strlen("sub_topic_{$main_topic_id}_"));
            $main_topic['sub_topics'][$sub_topic_id]['name'] = $value;
        } elseif (strpos($key, "video_link_{$main_topic_id}_") === 0) {
            $sub_topic_id = substr($key, strlen("video_link_{$main_topic_id}_"));
            $main_topic['sub_topics'][$sub_topic_id]['video_link'] = $value;
        } elseif (strpos($key, "word_file_link_{$main_topic_id}_") === 0) {
            $sub_topic_id = substr($key, strlen("word_file_link_{$main_topic_id}_"));
            $main_topic['sub_topics'][$sub_topic_id]['word_file_link'] = $value;
        } elseif (strpos($key, "exam_link_{$main_topic_id}_") === 0) {
            $sub_topic_id = substr($key, strlen("exam_link_{$main_topic_id}_"));
            $main_topic['sub_topics'][$sub_topic_id]['exam_link'] = $value;
        } elseif (strpos($key, "description_{$main_topic_id}_") === 0) {
            $sub_topic_id = substr($key, strlen("description_{$main_topic_id}_"));
            $main_topic['sub_topics'][$sub_topic_id]['description'] = $value;
        }
    }
}

$insertion_success = true;

foreach ($main_topics as $main_topic) {
    $main_topic_name = $conn->real_escape_string($main_topic['name']);
    $sql = "INSERT INTO main_topics (name, class_id) VALUES ('$main_topic_name', '$course_id')";
    if (!$conn->query($sql)) {
        $insertion_success = false;
        die("Error inserting main topic: " . $conn->error);
    }
    $main_topic_db_id = $conn->insert_id;

    foreach ($main_topic['sub_topics'] as $sub_topic) {
        $sub_topic_name = $conn->real_escape_string($sub_topic['name']);
        $video_link = $conn->real_escape_string($sub_topic['video_link'] ?? '');
        $word_file_link = $conn->real_escape_string($sub_topic['word_file_link'] ?? '');
        $exam_link = $conn->real_escape_string($sub_topic['exam_link'] ?? '');
        $description = $conn->real_escape_string($sub_topic['description']);

        $sql = "INSERT INTO sub_topics (main_topic_id, name, video_link, word_file_link, exam_link, description) VALUES ('$main_topic_db_id', '$sub_topic_name', '$video_link', '$word_file_link', '$exam_link', '$description')";
        if (!$conn->query($sql)) {
            $insertion_success = false;
            die("Error inserting sub-topic: " . $conn->error);
        }
    }
}

if ($insertion_success) {
    echo '<script>alert("Course Content Added Successfully!");window.location.href="content.php?course_id=' . $course_id . '";</script>';
}

$conn->close();
?>

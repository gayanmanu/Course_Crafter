<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
        }
        form, #course-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .main-topic, .sub-topic {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .main-topic h2 {
            margin: 0;
        }
        .sub-topic {
            margin-left: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="url"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        button[type="button"] {
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
</head>
<body>
    <a href="javascript:history.back()" class="back-button">Back</a>
    <?php
    session_start();
    if (isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];
    } else {
        $course_id = null;
    }
    ?>

    <h1 style="margin-top: 2%;">
        Content of Course ID:
        <?php 
        if ($course_id !== null) {
            echo htmlspecialchars($course_id);
        } else {
            echo "Course ID not set.";
        }
        ?>
    </h1>
    
    <h1>Add New Course</h1>
    <form id="courseForm" action="contentProccess.php" method="post">
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($course_id); ?>">
        <div id="main-topics-container">
            <div class="main-topic">
                <label>Main Topic Name: <input type="text" name="main_topic_1" required></label>
                <div class="sub-topics-container">
                    <div class="sub-topic">
                        <label>Sub-Topic Name: <input type="text" name="sub_topic_1_1" required></label>
                        <label>Video Link: <input type="url" name="video_link_1_1"></label>
                        <label>Word File Link: <input type="url" name="word_file_link_1_1"></label>
                        <label>Exam Link: <input type="url" name="exam_link_1_1"></label>
                        <label>Description: <textarea name="description_1_1"></textarea></label>
                    </div>
                </div>
                <button type="button" onclick="addSubTopic(this)">Add Sub-Topic</button>
            </div>
        </div>
        <button type="button" onclick="addMainTopic()">Add Main Topic</button><br/><br/>
        <button type="submit">Submit</button>
        <button type="submit">Update</button>
    </form>

    <h1>Edit Course Content</h1>
    <div id="course-content">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "CourseCraftersDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT mt.main_topic_id, mt.name as main_topic_name, 
                       st.sub_topic_id, st.name as sub_topic_name, 
                       st.video_link, st.word_file_link, st.exam_link, st.description 
                FROM main_topics mt 
                LEFT JOIN sub_topics st ON mt.main_topic_id = st.main_topic_id 
                WHERE mt.class_id = ?";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $topics = [];
        while ($row = $result->fetch_assoc()) {
            $main_topic_id = $row['main_topic_id'];
            if (!isset($topics[$main_topic_id])) {
                $topics[$main_topic_id] = [
                    'name' => $row['main_topic_name'],
                    'sub_topics' => []
                ];
            }
            if ($row['sub_topic_id']) {
                $topics[$main_topic_id]['sub_topics'][] = $row;
            }
        }

        foreach ($topics as $main_topic_id => $main_topic) {
            echo "<div class='main-topic'>
                    <h2>{$main_topic['name']}</h2>";
            echo "<button type='button' onclick='deleteMainTopic({$main_topic_id})'>Delete Main Topic</button>";
            foreach ($main_topic['sub_topics'] as $sub_topic) {
                echo "<div class='sub-topic'>
                        <p>
                            <strong>{$sub_topic['sub_topic_name']}</strong><br>
                            <a href='{$sub_topic['video_link']}'>Video</a> | 
                            <a href='{$sub_topic['word_file_link']}'>Word File</a> | 
                            <a href='{$sub_topic['exam_link']}'>Exam</a> | 
                            <button type='button' onclick='editSubTopic(".json_encode($sub_topic).")'>Edit</button> | 
                            <button type='button' onclick='deleteSubTopic({$sub_topic['sub_topic_id']})'>Delete</button>
                        </p>
                      </div>";
            }
            echo "</div>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>

    <script>
        let mainTopicCount = 1;
        let subTopicCount = {1: 1};

        function addMainTopic() {
            mainTopicCount++;
            subTopicCount[mainTopicCount] = 1;

            const mainTopicsContainer = document.getElementById('main-topics-container');
            const mainTopicDiv = document.createElement('div');
            mainTopicDiv.classList.add('main-topic');

            mainTopicDiv.innerHTML = `
                <label>Main Topic Name: <input type="text" name="main_topic_${mainTopicCount}" required></label>
                <div class="sub-topics-container">
                    <div class="sub-topic">
                        <label>Sub-Topic Name: <input type="text" name="sub_topic_${mainTopicCount}_1" required></label>
                        <label>Video Link: <input type="url" name="video_link_${mainTopicCount}_1"></label>
                        <label>Word File Link: <input type="url" name="word_file_link_${mainTopicCount}_1"></label>
                        <label>Exam Link: <input type="url" name="exam_link_${mainTopicCount}_1"></label>
                        <label>Description: <textarea name="description_${mainTopicCount}_1"></textarea></label>
                    </div>
                </div>
                <button type="button" onclick="addSubTopic(this)">Add Sub-Topic</button>
            `;
            mainTopicsContainer.appendChild(mainTopicDiv);
        }

        function addSubTopic(button) {
            const mainTopicDiv = button.parentElement;
            const mainTopicId = mainTopicDiv.querySelector('input[name^="main_topic"]').name.split('_')[2];
            subTopicCount[mainTopicId]++;

            const subTopicsContainer = mainTopicDiv.querySelector('.sub-topics-container');
            const subTopicDiv = document.createElement('div');
            subTopicDiv.classList.add('sub-topic');

            subTopicDiv.innerHTML = `
                <label>Sub-Topic Name: <input type="text" name="sub_topic_${mainTopicId}_${subTopicCount[mainTopicId]}" required></label>
                <label>Video Link: <input type="url" name="video_link_${mainTopicId}_${subTopicCount[mainTopicId]}"></label>
                <label>Word File Link: <input type="url" name="word_file_link_${mainTopicId}_${subTopicCount[mainTopicId]}"></label>
                <label>Exam Link: <input type="url" name="exam_link_${mainTopicId}_${subTopicCount[mainTopicId]}"></label>
                <label>Description: <textarea name="description_${mainTopicId}_${subTopicCount[mainTopicId]}"></textarea></label>
            `;
            subTopicsContainer.appendChild(subTopicDiv);
        }

        function editSubTopic(subTopic) {
            const form = document.getElementById('courseForm');
            form.querySelector('input[name="main_topic_1"]').value = subTopic.main_topic_name;
            form.querySelector('input[name="sub_topic_1_1"]').value = subTopic.sub_topic_name;
            form.querySelector('input[name="video_link_1_1"]').value = subTopic.video_link;
            form.querySelector('input[name="word_file_link_1_1"]').value = subTopic.word_file_link;
            form.querySelector('input[name="exam_link_1_1"]').value = subTopic.exam_link;
            form.querySelector('textarea[name="description_1_1"]').value = subTopic.description;
        }

        function deleteSubTopic(subTopicId) {
            if (confirm('Are you sure you want to delete this sub-topic?')) {
                const xhttp = new XMLHttpRequest();
                xhttp.open("POST", "deleteSubTopic.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.onreadystatechange = function() {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        alert(xhttp.responseText);
                        location.reload();
                    }
                };
                xhttp.send(`sub_topic_id=${subTopicId}`);
            }
        }

        function deleteMainTopic(mainTopicId) {
            if (confirm('Are you sure you want to delete this main topic and all its sub-topics?')) {
                const xhttp = new XMLHttpRequest();
                xhttp.open("POST", "deleteMainTopic.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.onreadystatechange = function() {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        alert(xhttp.responseText);
                        location.reload();
                    }
                };
                xhttp.send(`main_topic_id=${mainTopicId}`);
            }
        }
    </script>
</body>
</html>

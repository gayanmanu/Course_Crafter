<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Course</title>
    <style>
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
    </style>
</head>

<body>

    <div style="width: 80%; margin: 0 auto; padding: 20px;">

        <!-- Heading -->
        <h2>Python Course</h2>

        <!-- Main Topics -->
        <div id="mainTopics">
            <!-- Main Topic 1 -->
            <button class="main-topic-button" onclick="toggleVisibility('subTopics1')">Overview of Python</button>
            <ul id="subTopics1" class="sub-topic-list">
                <li style=" padding-bottom: 10px;"><a href="path/to/history.pdf" target="_blank" style="text-decoration:none;">History and evolution</a></li>
                <li style="padding-bottom: 10px;"><p>The history and evolution of Python trace a compelling journey in the world of programming languages. Conceived in the late 1980s by Guido van Rossum, Python aimed to address shortcomings in existing languages and prioritize code readability. The language's name, inspired by the British comedy group Monty Python, reflects its emphasis on humor and accessibility.

				Python's initial release in 1991 marked the beginning of its ascent. Over the years, it garnered a reputation for simplicity and versatility, attracting a diverse community of developers. One pivotal moment came with the release of Python 2 in 2000, introducing new features and improvements. However, as the language continued to evolve, Python 3 emerged in 2008, addressing inconsistencies and enhancing performance.

				Python's growth transcended boundaries, finding applications in web development, data science, artificial intelligence, and more. Its readability and ease of learning contributed to its widespread adoption, making it a go-to language for both beginners and seasoned developers. Today, Python stands as one of the most popular and influential programming languages, shaping the landscape of technology and innovation. Its evolution reflects a commitment to adaptability, community collaboration, and a dedication to making programming accessible to all.</p></li>
                <a href="Doc1.pdf" target="_blank"><img src="pdf.png" style="width:40px; padding-bottom: 10px; padding-right: 50px;"> <img src="video.png" style="width:40px; padding-bottom: 10px;"></a>
                <li><a href="path/to/python2vs3.pdf" target="_blank" style="text-decoration:none;">Python 2 vs Python 3</a></li>
            </ul>

            
        </div>

        <script>
            function toggleVisibility(subTopicsId) {
                // Toggle the visible-sub-topic class for the clicked sub-topic list
                var subTopics = document.getElementById(subTopicsId);
                subTopics.classList.toggle('visible-sub-topic');
            }
        </script>

    </div>

</body>

</html>

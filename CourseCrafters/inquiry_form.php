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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inquiry Form</title>
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
        .inquiry-form, .inquiry-list {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 40%;
            margin: auto;
            margin-bottom: 20px;
        }
        .inquiry-form{
            margin-top: 8%;
        }
        .inquiry-form h2, .inquiry-list h2 {
            margin-top: 0;
        }
        .inquiry-form label, .inquiry-list label {
            display: block;
            margin-top: 10px;
        }
        .inquiry-form input[type="email"],
        .inquiry-form textarea {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .inquiry-form textarea {
            height: 150px;
        }
        .inquiry-form input[type="submit"] {
            display: block;
            margin-top: 20px;
            padding: 10px 15px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .inquiry-form input[type="submit"]:hover {
            background-color: #218838;
        }
        .inquiry-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .inquiry-list table, .inquiry-list th, .inquiry-list td {
            border: 1px solid #ddd;
        }
        .inquiry-list th, .inquiry-list td {
            padding: 8px;
            text-align: left;
        }
        .inquiry-list th {
            background-color: #f2f2f2;
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
                <a class="active" href="inquiry_form.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Inquiry
                </a>
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

    <div class="inquiry-form">
        <h2>Submit Inquiry</h2>
        <form method="post" action="inquiry_submit.php">
            <?php

            if(isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
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

                // Fetch the user's email from the users table
                $sql = "SELECT email FROM users WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stmt->bind_result($email);
                $stmt->fetch();
                $stmt->close();
            } else {
                // If user is not logged in, redirect to login page
                header("Location: register.php");
                exit();
            }
            ?>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required><br><br>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea><br><br>

            <input type="submit" value="Submit Inquiry">
        </form>
    </div>

    <div class="inquiry-list">
        <h2>Your Inquiries</h2>
        <?php
        // Fetch the user's inquiries from the inquiry table
        $sql = "SELECT inquiry_date, message, status, response FROM inquiry WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Date</th><th>Message</th><th>Status</th><th>Response</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['inquiry_date']) . '</td>';
                echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '<td>' . htmlspecialchars($row['response']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No inquiries submitted yet.</p>';
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>






    <?php include 'footer.php'; ?>

    

</body>
</html>
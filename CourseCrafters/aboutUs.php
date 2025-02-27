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
	<title>About US</title>
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

        .container59 {
            width: 60%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container59 p {
            text-align: justify;
            margin-bottom: 15px;
        }
        .container59 h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .container59 .highlight {
            font-weight: bold;
            color: #0056b3;
        }
        .container59 .mission {
            font-style: italic;
        }
        .container59 .team {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-left: 4px solid #007bff;
        }
        .container59 .team h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .container59 .team p {
            margin-bottom: 10px;
        }
        .container59 .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #45a049;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .container59 .cta-button:hover {
            background-color: #0056b3;
        }

        .container79 {
            width: 60%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container79 p {
            text-align: justify;
            margin-bottom: 15px;
        }
        .container79 h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .container79 .highlight {
            font-weight: bold;
            color: #0056b3;
        }
        .container79 .mission {
            font-style: italic;
        }
        .container79 .team {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-left: 4px solid #007bff;
        }
        .container79 .team h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .container79 .team .founders {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .container79 .team .founder {
            text-align: center;
            width: 200px;
        }
        .container79 .team .founder img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .container79 .team .founder .name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .container79 .team .founder .email {
            color: #333;
        }
        .container79 .team .founder .degree {
            font-style: italic;
            color: #666;
        }
        .container79 .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        .container79 .cta-button:hover {
            background-color: #0056b3;
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
                <a href="inquiry_form.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Inquiry</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="aboutUs.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    About US
                </a>
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

        <div class="container79">
        <h2>Welcome to CourseCrafters</h2>
        <p>At <span class="highlight">CourseCrafters</span>, we are passionate about empowering learners to achieve their educational goals through high-quality online courses. Our mission is to provide accessible and engaging learning experiences that inspire personal growth and professional development.</p>
        
        <p>Founded in <span class="highlight">2024</span>, <span class="highlight">CourseCrafters</span> began with a vision to bridge the gap between traditional education and modern learning needs. Our team of dedicated educators and technologists collaborates to create courses that blend academic rigor with practical application.</p>
        
        <div class="team">
            <h3>Meet Our Team</h3>
            <div class="founders">
                <div class="founder">
                    <img src="founder1.png" alt="Founder 1">
                    <div class="name">Rasanjana LPSK</div>
                    <div class="degree">Owner & Founder</div>
                    <div class="email">e2145285@bit.uom.lk.com</div>
                    <div class="degree">Freelance Web Developer</div>
                </div>
                <div class="founder">
                    <img src="founder2.png" alt="Founder 2">
                    <div class="name">Premarathna KVDPKP</div>
                    <div class="degree">Owner & Founder</div>
                    <div class="email">e2145270@bit.uom.lk</div>
                    <div class="degree">Freelance Web Developer</div>
                </div>
                <div class="founder">
                    <img src="founder3.png" alt="Founder 3">
                    <div class="name">Aththanayaka AMGM</div>
                    <div class="degree">Owner & Founder</div>
                    <div class="email">e2145049@bit.uom.lk</div>
                    <div class="degree">Freelance Web Developer</div>
                </div>
            </div>
        </div>
        
        <p>Our commitment to <span class="highlight">excellence</span> drives everything we do. From designing interactive course modules to supporting our community of learners, we are dedicated to fostering a culture of continuous learning and innovation.</p>
        
        <p>Join us on this journey to discover new opportunities and expand your horizons. Explore our courses and start your learning adventure today with <span class="highlight">CourseCrafters</span>.</p>
        
        <p class="mission">Together, let’s <span class="highlight">learn, grow, and succeed</span>!</p>
        
        <a href="All Courses.php" class="cta-button">Explore Courses</a>
    </div>


    <?php include 'footer.php'; ?>

    

</body>
</html>
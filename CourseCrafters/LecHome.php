<?php
session_start();


if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

} else {
    header("Location: lecturerReg.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <div style="width:100%;">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #000000; width: 100%;">
            <li style="float: left; padding-left: 30px; height: 80px;">
                <a href="LecHome.php" style="display: block; height: 100%;">
                    <img src="logo-no-background.png" alt="Logo" style="height: 50px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="LecHome.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; background-color: #45a049; border-radius: 20px;">
                    Home
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="LecDashboard.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Add Courses</a>
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









    <!-- Join With Course Crafters -->
    <div style="height: 80%; width: 100%; background-color: rgba(255, 255, 255, 0.7); margin-top: 50px; background-size: cover; display: flex; align-items: center;">

	    <div style="flex: 1; padding-left: 10%; padding-righslide:jpg%; padding-top: 10%;">
	        <h1 style="color: #4caf50; font-size: 50px;">COURSE CRAFTER</h1>
	        <p style="font-size: 20px;">
	            Explore unlimited opportunities with the course <br/>
	            Get unlimited access to an unlimited pool of artists <br/>
	            World-class courses, hands-on projects, and job <br/>
	            preparation Certificate programs. Your subscription <br/>
	            includes everything, Empowering you to unlock your<br/>
	            full potential.
	        </p>
	    </div>

	    <div style="flex: 1;">
	        <img src="coverHome.png" style="width: 100%;">
	    </div>
	</div>



	<div style="height: 500px; width: 100%; background-color: rgba(255, 255, 255, 0.7); margin-top: 0px; text-align: center;">
		<h2 style="color: #4caf50; font-size: 30px; padding-top: 0px;">Join With Course Crafters</h2>
		<p style="font-size: 20px;">Apply for these exciting new courses. Join now!</p>
		<button type="submit" name="login" style="background-color: #4caf50; color: #fff; padding: 10px; border: none; border-radius: 4px; cursor: pointer; width: 10%;" onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4caf50'">JOIN NOW</button>
		<p style="font-size: 12px; margin-bottom: 100px;">Join With Our New Courses</p>
	</div>

	


	<!-- Find Your Level From Here -->
	<div style="background-color:white;width: 100%;text-align: center; margin-top: 50px; padding-top: 20px;">
		<p style="color: black; font-size:30px;padding-bottom: 30px;">
			<b>Find Your Level From Here<b>
		</p>	
	</div>

	<div style="display: flex; justify-content: space-around; align-items: center; background-color: white;padding-bottom: 50px;">

		<div style="margin-right: 80px;">
			<a href="" style="text-decoration:none; color: black;">
				<img src="beginner.png" style="width: 80px;">
				<p>Beginner Level</p>
			</a>
		</div>


		<div style="margin-right: 80px;">
			<a href="" style="text-decoration:none; color: black;">
				<img src="intermediate.png" style="width: 80px;">
				<p>Intermediate Level</p>
			</a>
		</div>

		<div>
			<a href="" style="text-decoration:none; color: black;">
				<img src="expert.png" style="width: 80px;">
				<p>Expert Level</p>
			</a>
		</div>
	</div>


	<!-- Enhance your professional journey with Course Crafters. -->
	<div style="background-color:white;width: 100%;text-align: center; margin-top: 50px; padding-top: 20px;">
		<p style="color: black; font-size:30px;padding-bottom: 30px; margin-bottom: 0px;">
			<b>Enhance your professional journey with Course Crafters.<b>
		</p>	
	</div>

	<div style="display: flex; justify-content: space-around; align-items: center; background-color: white;padding-bottom: 50px;">

		<div style="margin-right: 20px; display: flex; flex-direction: column; align-items: center;">
			<a href="" style="text-decoration: none; color: black;">
				<img src="learnanything.png" style="width: 80px;margin-left: 140px;">
				<p style="margin-left: 135px;">Learn 24x7</p>
				<p style="text-align: center; font-size:12px; margin-left:30px;">Discover your passion or delve<br/> into trending subjects, complete prerequisites, and<br/> elevate your skills.</p>
			</a>
		</div>



		<div style="margin-right: 80px; display: flex; flex-direction: column; align-items: center;">
			<a href="" style="text-decoration: none; color: black;">
				<img src="savemoney.png" style="width: 80px;margin-left: 100px;">
				<p style="margin-left: 95px;">Save Money</p>
				<p style="text-align: center; font-size:12px; margin-left:05px;">Invest in your career growth by saving more<br/> on learning. Enroll in Coursera Plus<br/> to spend less on multiple coursesthroughout <br/> the year.</p>
			</a>
		</div>

		<div style="margin-right: 80px; display: flex; flex-direction: column; align-items: center;">
			<a href="" style="text-decoration: none; color: black;">
				<img src="flexiblelearning.png" style="width: 80px;margin-left: 82px;">
				<p style="margin-left: 65px;">Flexible learning</p>
				<p style="text-align: center; font-size:12px; margin-left:0px;">Explore courses on your terms. Learn<br/> at your own pace, seamlessly<br/> move between multiple courses, or switch<br/> to a different course when<br/> you choose.</p>
			</a>
		</div>


		<div style="margin-right: 80px; display: flex; flex-direction: column; align-items: center;">
			<a href="" style="text-decoration: none; color: black;">
				<img src="savetime.png" style="width: 80px;margin-left: 65px;">
				<p style="margin-left: 60px;">Save Time</p>
				<p style="text-align: center; font-size:12px; margin-left:05px;">Save time by choosing the courses<br/> that matter most to you and align<br/> with your goals.</p>
			</a>
		</div>


	</div>


	<!-- PayHere Logo. -->
	<div style="background-color: black; width: 60%; text-align: center;padding-top: 5px; margin-top: 50px; padding-top: 8px; padding-bottom: 8px; margin-left: auto; margin-right: auto; border-radius: 80px 0px 80px 0px;">
		<div>
			<p style="font-size: 30px; color: black; color: #45a049;">Payment Powered BY
				<a href="https://www.payhere.lk" target="_blank">
					<img src="https://www.payhere.lk/downloads/images/payhere_short_banner_dark.png" alt="PayHere" width="250" / style="margin-left: 80px;">
				</a>
			</p>
		</div>
	</div>




    <!-- Footer -->
    <br/><br/>
    <br/><br/>

    <footer style="background-color: #000000; color: #fff; padding: 20px; max-width: 100%;">
        <div style="margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">

            <!-- First Row - First Column -->
            <div style="padding-left: 50px;">
                <a href="#" style="text-decoration: none; color: white;">
                    <img src="logo-no-background.png" alt="Course Crafters Logo" style="width: 80px; height: auto; margin-bottom: 20px;">
                </a>
                <p style="text-align: left;">Vision: Empower course creators with a comprehensive web-based platform that simplifies the process of crafting and delivering courses, while fostering collaboration and innovation in education.</p>
                <p style="text-align: left;">Mission: Provide a revolutionized online education experience with technology.</p>
            </div>

            <!-- First Row - Second Column -->
            <div>
                <h2 style="text-align:left;">Quick Access</h2>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: white;">Home</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">About Us</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">What We Offer</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">Our Team</a></li>
                </ul>

                <p>
                    <a href="#" style="text-decoration: none; color: white;">Terms of Use</a> || 
                    <a href="#" style="text-decoration: none; color: white;">Cookie Notice</a> || 
                    <a href="#" style="text-decoration: none; color: white;">Privacy & Policy</a>
                </p>
            </div>

            <!-- First Row - Third Column -->
            <div>
                <h2 style="text-align:left;">Connect With Us</h2>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: white;">Contact Us</a></li>
                    <li>Hotline: 0772005648</li>
                    <li>Email: <a href="mailto:coursecraft3@gmail.com" style="text-decoration: none; color: white;">coursecraft3@gmail.com</a></li>
                </ul><br/>

                <h2 style="text-align:left;">Follow Us On</h2>
                <ul style="list-style: none; padding: 0; display: flex; justify-content: flex-start; margin-top: 10px;">
                    <li><a href="#" style="text-decoration: none; color: white;"><img src="facebook.png" alt="Facebook" style="width: 20px; margin-right: 10px;"></a></li>
                    <li><a href="#" style="text-decoration: none; color: white;"><img src="instagram.png" alt="Instagram" style="width: 20px; margin-right: 10px;"></a></li>
                    <li><a href="#" style="text-decoration: none; color: white;"><img src="whatsapp.png" alt="WhatsApp" style="width: 20px;"></a></li>
                </ul>
            </div>

            <!-- First Row - Fourth Column -->
            <div>
                <h2 style="text-align:left;">Popular Courses</h2>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: white;">Java Basic Course</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">Web Development For Beginner</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">Mobile Application Development</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">C# Expert Course</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">Java Script Full Course</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">HTML & CSS Basic Course</a></li>
                    <li><a href="#" style="text-decoration: none; color: white;">Database Management System</a></li>
                </ul>
            </div>
        </div>
    </footer>


    <!-- Second Row -->
    <div style="background-color: #4caf50; padding: 20px; text-align: center;max-width: 100%;">
        <p style="color: #fff;font-size: 10px">2024 &copy; COURSE CRAFTERS EDUCATION. ALL RIGHTS RESERVED | CONCEPT & DESIGN BY KPG Code.</p>
        <p style="color: #fff;font-size: 10px">DEVELOPED BY KPG Code</p>
    </div>

</body>

</html>


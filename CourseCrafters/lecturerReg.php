<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
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

        header {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        header img {
            width: 100px;
            height: auto;
            margin-top: 30px; /* Adjust the top margin for the logo */
            margin-right: 10px;
        }

        header h1 {
            font-size: 2em;
            margin: 20px 0 0;
            font-family: 'Roboto', sans-serif;
        }

        /* Add an underline effect */
        header h1::after {
            content: "";
            display: block;
            width: 50%;
            height: 2px;
            background-color: #fff;
            position: absolute;
            bottom: 0;
            left: 25%;
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            z-index: 2;
            transition: opacity 0.5s ease-in-out;
        }
        

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input,select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .register-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>

    <!-- Include the Roboto font from Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap">
</head>
<body>

    <!-- Navigation Bar -->
    <div style="width:100%;">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #000000; width: 100%;">
            <li style="float: left; padding-left: 30px; height: 80px;">
                <a href="Dashboard.php" style="display: block; height: 100%;">
                    <img src="logo-no-background.png" alt="Logo" style="height: 50px; width: auto; padding: 10px;">
                </a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a class="active" href="Dashboard.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Home</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="#All Courses" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">All Courses</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="#category" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Category</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="#contactus" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Contact US</a>
            </li>

            <li style="float: left; padding-top: 20px;">
                <a href="#aboutus" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">About US</a>
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
        </ul>
    </div>


    <header>
        <img src="logo-no-background.png" alt="Logo">
        <h1>COURSE CRAFTERS</h1>
    </header>

    <!-- Login Form -->
    <form id="loginForm" action="lecRegProccess.php" method="post" style="display: block;">
        <h2>Lecture Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login" style="background-color: #4caf50; color: #fff; padding: 10px; border: none; border-radius: 4px; cursor: pointer; width: 100%;" onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4caf50'">Login</button>

        <p class="register-link">Don't have an account? <a href="#" onclick="showRegisterForm()">Register</a></p>
    </form>

    <!-- Register Form -->
    <form id="registerForm" style="display: none;" action="lecRegProccess.php" method="post">
        <h2>Lecture Registretion</h2>

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="telephone">Telephone Number:</label>
        <input type="tel" id="telephone" name="telephone" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="newPassword">Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>

        <button type="submit" name="register" style="background-color: #4caf50; color: #fff; padding: 10px; border: none; border-radius: 4px; cursor: pointer; width: 100%;" onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4caf50'">Register</button>

        <p class="register-link">Already have an account? <a href="#" onclick="showLoginForm()">Login</a></p>
    </form>

    <script>
    function showRegisterForm() {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
    }

    function showLoginForm() {
        document.getElementById('registerForm').style.display = 'none';
        document.getElementById('loginForm').style.display = 'block';
    }
    </script>

    <a href="index.php" style="color: white; text-decoration: none;"><p>Student Registertion</p></a>



    <!-- Footer -->
    <br/><br/>
    <br/><br/>

    <footer style="background-color: #000000; color: #fff; padding: 20px;width: 100%;">
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
                    <li><a href="#" style="text-decoration: none; color: white;"><img src="instagram.png" alt="Instagram" style="width: 25px; margin-right: 10px;"></a></li>
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
    <div style="background-color: #4caf50; padding: 20px; text-align: center;width: 100%;">
        <p style="color: #fff;font-size: 10px">2024 &copy; COURSE CRAFTERS EDUCATION. ALL RIGHTS RESERVED | CONCEPT & DESIGN BY KPG Code.</p>
        <p style="color: #fff;font-size: 10px">DEVELOPED BY KPG Code</p>
    </div>

</body>

</html>


</body>
</html>

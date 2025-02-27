<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = "";     // Change this to your MySQL password
$dbname = "CourseCraftersDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $loginUsername = $_POST['username'];
        $loginPassword = $_POST['password'];

        // Escape user inputs for security
        $loginUsername = $conn->real_escape_string($loginUsername);
        $loginPassword = $conn->real_escape_string($loginPassword);

        // Perform SQL query to validate login and check status
        $sql = "SELECT * FROM teachers WHERE email='$loginUsername' AND password='$loginPassword'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['Status'] == 'pending') {
                echo '<script>alert("Login failed. Your account is pending approval."); 
                window.history.back();</script>';
            } else {
                // Set the session variables
                $_SESSION['username'] = $loginUsername;
                $_SESSION['teacher_id'] = $row['teacher_id']; // Corrected line

                // Redirect to a common dashboard page
                header("Location: LecHome.php");
                exit();
            }
        } else {
            echo '<script>alert("Login failed. Invalid username or password."); 
                window.history.back();</script>';
        }
    } elseif (isset($_POST['register'])) {
        $registerPassword = $_POST['newPassword'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        // Escape user inputs for security
        $registerPassword = $conn->real_escape_string($registerPassword);
        $firstName = $conn->real_escape_string($firstName);
        $lastName = $conn->real_escape_string($lastName);
        $address = $conn->real_escape_string($address);
        $telephone = $conn->real_escape_string($telephone);
        $email = $conn->real_escape_string($email);

        // Perform SQL query to insert new user with additional fields
        $sql = "INSERT INTO teachers (password, first_name, last_name, address, telephone, email, Status) 
                VALUES ('$registerPassword', '$firstName', '$lastName', '$address', '$telephone', '$email', 'pending')";

        if ($conn->query($sql) === TRUE) {
            // Display registration successful alert
            echo '<script>alert("Registration successful!");';
            echo 'window.location = "' . $_SERVER['HTTP_REFERER'] . '#login";</script>'; // Redirect using JavaScript
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

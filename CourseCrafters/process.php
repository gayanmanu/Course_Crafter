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

        // Perform SQL query to validate login
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $loginUsername, $loginPassword);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        if ($user_id) {
            // Set the session variable
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $loginUsername;

            // Redirect to a common dashboard page
            header("Location: Dashboard.php");
            exit();
        } else {
            echo "Login failed. Invalid username or password.";
        }
    } elseif (isset($_POST['register'])) {
        $registerUsername = $_POST['newUsername'];
        $registerPassword = $_POST['newPassword'];
        $firstName = $_POST['firstName']; // Add these lines to retrieve new fields
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        // Escape user inputs for security
        $registerUsername = $conn->real_escape_string($registerUsername);
        $registerPassword = $conn->real_escape_string($registerPassword);
        $firstName = $conn->real_escape_string($firstName);
        $lastName = $conn->real_escape_string($lastName);
        $address = $conn->real_escape_string($address);
        $telephone = $conn->real_escape_string($telephone);
        $email = $conn->real_escape_string($email);

        // Perform SQL query to insert new user with additional fields
        $sql = "INSERT INTO users (password, firstName, lastName, address, telephone, email) 
                VALUES ('$registerPassword', '$firstName', '$lastName', '$address', '$telephone', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";

            // Redirect to the login form after successful registration
            header("Location: {$_SERVER['HTTP_REFERER']}#login");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

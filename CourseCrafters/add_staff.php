<?php
$servername = "localhost"; // Change this to your server's name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "CourseCraftersDB"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $conn->real_escape_string($_POST['name']);
    $position = $conn->real_escape_string($_POST['position']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $password = $conn->real_escape_string($_POST['password']); // Hash the password

    // Insert data into the staff table
    $sql = "INSERT INTO staff (name, position, email, phone_number, password) VALUES ('$name', '$position', '$email', '$phone_number', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("New staff member added successfully"); window.location.href="addStaff.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<?php
session_start(); // Start the session to access session variables

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or appropriate error handling
    header("Location: index.php");
    exit(); // Ensure that script stops here
}

$user_id = $_SESSION['user_id']; // Retrieve user_id from session

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

// Fetch user information
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        // Update user information
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        $updateSql = "UPDATE users SET firstName = ?, lastName = ?, address = ?, telephone = ?, email = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssssi", $firstName, $lastName, $address, $telephone, $email, $user_id);

        if ($updateStmt->execute()) {
            echo '<script>alert("User information updated successfully."); window.location.href="editProfile.php";</script>';

            // Fetch the updated information
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
        } else {
            echo "Error updating user information: " . $conn->error;
        }

        $updateStmt->close();
    } elseif (isset($_POST['delete'])) {
        // Delete user account
        $deleteSql = "DELETE FROM users WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $user_id);

        if ($deleteStmt->execute()) {
            // Logout the user and redirect to the registration page
            session_destroy();
            echo '<script>alert("Account deleted successfully."); window.location.href="index.php";</script>';
            exit();
        } else {
            echo "Error deleting account: " . $conn->error;
        }

        $deleteStmt->close();
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
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
        .container {
            width: 40%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input[type="text"], input[type="email"] {
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            margin: 20px 0;
            width: 150px;
            align-self: center;
        }
        button:hover {
            background-color: #0056b3;
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
        .delete-button {
            background-color: #ff0000;
            margin-top: 10px;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <a href="Dashboard.php" class="back-button">Back</a>
    <div class="container">
        <h2>Edit Profile <?php echo htmlspecialchars($user['firstName'] . " " . $user['lastName']); ?></h2>
        <form method="post">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>" required>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

            <label for="telephone">Telephone:</label>
            <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <button type="submit" name="update">Save Changes</button>
        </form>
        <form method="post">
            <button type="submit" name="delete" class="delete-button">Delete Account</button>
        </form>
    </div>
</body>
</html>

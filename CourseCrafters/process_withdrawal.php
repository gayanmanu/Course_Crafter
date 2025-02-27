<?php
session_start(); // Start the session

if (isset($_POST['submit'])) {
    // Retrieve form data
    $teacher_id = $_POST['teacher_id'];
    $amount = $_POST['amount'];
    $account_number = $_POST['account_number'];
    $account_branch = $_POST['account_branch'];
    $account_name = $_POST['account_name'];
    $owner_name = $_POST['owner_name'];

    // Validate amount against current balance
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

    // Query to fetch current balance
    $sql_balance = "
    SELECT 
        COALESCE(SUM(course_payments.total_payment), 0) - COALESCE(SUM(withdrawals.total_withdrawal), 0) AS current_balance
    FROM 
        teachers t
    LEFT JOIN (
        SELECT 
            c.teacher_id,
            SUM(c.course_fee) AS total_payment
        FROM 
            courses c
        LEFT JOIN 
            coursepayment cp ON c.class_id = cp.course_id
        GROUP BY 
            c.teacher_id
    ) course_payments ON t.teacher_id = course_payments.teacher_id
    LEFT JOIN (
        SELECT 
            teacher_id,
            SUM(amount) AS total_withdrawal
        FROM 
            withdrawal
        WHERE 
            status = 'completed'
        GROUP BY 
            teacher_id
    ) withdrawals ON t.teacher_id = withdrawals.teacher_id
    WHERE 
        t.teacher_id = $teacher_id
    GROUP BY 
        t.teacher_id";

    $result_balance = $conn->query($sql_balance);

    if ($result_balance->num_rows > 0) {
        $row = $result_balance->fetch_assoc();
        $current_balance = $row['current_balance'];

        // Check if requested amount is within the current balance
        if ($amount > 0 && $amount <= $current_balance) {
            // Insert withdrawal request into database
            $sql_insert = "
            INSERT INTO withdrawal (teacher_id, withdrawal_date, amount, status, account_number, account_branch, account_name, owner_name)
            VALUES ('$teacher_id', CURDATE(), '$amount', 'pending', '$account_number', '$account_branch', '$account_name', '$owner_name')";

            if ($conn->query($sql_insert) === TRUE) {
                echo '<script>alert("Withdrawal request submitted successfully!");</script>';
                header("Location: withdrawal.php"); // Redirect to withdrawal page
                exit();
            } else {
                echo "Error: " . $sql_insert . "<br>" . $conn->error;
            }
        } else {
            echo '<script>alert("Invalid withdrawal amount. Please enter a valid amount."); window.history.back();</script>';
        }
    } else {
        echo "Error: Unable to fetch current balance.";
    }

    $conn->close();
} else {
    echo "Unauthorized access!";
}
?>

<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check in admin table
    $sqlAdmin = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $resultAdmin = $conn->query($sqlAdmin);

    // Check in student table
    $sqlStudent = "SELECT * FROM student WHERE username = '$username' AND password = '$password'";
    $resultStudent = $conn->query($sqlStudent);

    if ($resultAdmin->num_rows > 0) {
        $row = $resultAdmin->fetch_assoc();
        
        // Start the session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Set session variables
        $_SESSION['user_id'] = $row['LIB_ID'];
        $_SESSION['user_type'] = 'admin';

        // Redirect to admin home page
        header("Location: home_admin.php");
        exit();
    } elseif ($resultStudent->num_rows > 0) {
        $row = $resultStudent->fetch_assoc();
        
        // Start the session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Set session variables
        $_SESSION['user_id'] = $row['STU_ID'];
        $_SESSION['user_type'] = 'student';

        // Redirect to student home page
        header("Location: home_student.php");
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password";
    }
}
?>

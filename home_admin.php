<?php
include("config.php");

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch admin info
$user_id = $_SESSION['user_id'];
$sqluser = "SELECT * FROM admin WHERE LIB_ID ='$user_id'";
$query_user = $conn->query($sqluser);
$rowuser = $query_user->fetch_assoc();

// Ensure admin info is fetched successfully
if (!$rowuser) {
    echo "Error fetching admin information.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h3 {
            margin: 10px 0;
        }
        .sidebar {
            height: 100%;
            width: 300px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #3f51b5;
            padding-top: 20px;
            color: white;
            text-align: center;
        }
        .sidebar a {
            display: block;
            padding: 16px;
            text-decoration: none;
            color: white;
            font-size: 20px;
        }
        .sidebar a:hover {
            background-color: #4658F8; /* Slightly darker shade */
        }
        .content {
            margin-left: 320px; /* Adjusted for sidebar width + padding */
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-radius: 8px 8px 0 0;
                margin-bottom: 20px;
                box-shadow: none;
                position: static; /* Change position to static on smaller screens */
            }
            .content {
                margin-left: 0; /* Adjust for no sidebar */
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <h2>LIBRIFY</h2>
    <a href="home_admin.php">Home</a>
    <a href="add_book.php">Add Book</a>
    <a href="view_book.php">View Book</a>
    <a href="view_br.php">View History</a>
    <a href="logout.php">Logout</a>
</nav>

<!-- Page content -->
<div class="content">
    <div class="container">
        <h1>Welcome to LIBRIFY Admin Panel</h1>
        <h3>User ID: <?php echo $rowuser['LIB_ID']; ?></h3>
        <h3>Username: <?php echo $rowuser['username']; ?></h3>
        <h3>Email: <?php echo $rowuser['LIB_EMAIL']; ?></h3>
    </div>
</div>

</body>
</html>

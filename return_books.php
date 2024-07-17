<?php
include("config.php");

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
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
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #c2185b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #d81b60;
        }
        .content {
            margin-left: 320px; /* Adjusted for sidebar width + padding */
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            height: 100%;
            width: 300px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #c2185b;
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
            background-color: #d81b60; /* Slightly darker shade */
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
	 <script>
        // JavaScript to set min date for return date input with Malaysia timezone
        document.addEventListener('DOMContentLoaded', function() {
            var today = new Date();
            today.setHours(today.getHours() + 8); // Adjust for Malaysia timezone (UTC+8)
            var malaysiaDate = today.toISOString().split('T')[0];
            document.getElementById('return_date').setAttribute('min', malaysiaDate);
        });
    </script>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <h2>LIBRIFY</h2>
    <a href="home_student.php">Home</a>
    <a href="view_books.php">View Books</a>
    <a href="return_books.php">Return Books</a>
    <a href="view_borrow.php">View Borrowed and Returned Books</a>
    <a href="logout.php">Logout</a>
</nav>

<!-- Page content -->
<div class="content">
    <div class="container">
        <h2>Return Books</h2>
        <form method="post" action="process_return.php">
            <label for="book_code">Book Code:</label>
            <input type="text" id="book_code" name="book_code" required>

            <label for="return_date">Return Date (YYYY-MM-DD):</label>
            <input type="date" id="return_date" name="return_date" required>

            <input type="submit" value="Return Book">
        </form>
    </div>
</div>

</body>
</html>

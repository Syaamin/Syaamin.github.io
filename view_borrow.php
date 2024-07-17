<?php
include("config.php");

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch user info
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

// Fetch borrowed and returned books for the user
$sql = "SELECT book.BOOK_CODE, book.BOOK_TITLE, book.BOOK_AUTHOR, set_of_borrow.BORROW_DATE, set_of_borrow.DUE_DATE, set_of_borrow.RETURN_DATE, set_of_borrow.FINE_AMOUNT 
        FROM set_of_borrow 
        JOIN book ON set_of_borrow.BOOK_CODE = book.BOOK_CODE
        WHERE set_of_borrow.STU_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Borrowed and Returned Books</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #c2185b;
            color: white;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            padding: 8px;
            width: 80%;
            max-width: 500px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-form input[type="submit"] {
            padding: 8px 16px;
            background-color: #c2185b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-form input[type="submit"]:hover {
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
        .back-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #45a049;
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
    <a href="home_student.php">Home</a>
    <a href="view_books.php">View Books</a>
    <a href="return_books.php">Return Books</a>
    <a href="view_borrow.php">View Borrowed and Returned Books</a>
    <a href="logout.php">Logout</a>
</nav>

<!-- Page content -->
<div class="content">
    <div class="container">
        <h2>Borrowed and Returned Books</h2>
        <table>
            <tr>
                <th>Book Code</th>
                <th>Title</th>
                <th>Author</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Fine Amount (RM)</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['BOOK_CODE']); ?></td>
                <td><?php echo htmlspecialchars($row['BOOK_TITLE']); ?></td>
                <td><?php echo htmlspecialchars($row['BOOK_AUTHOR']); ?></td>
                <td><?php echo htmlspecialchars($row['BORROW_DATE']); ?></td>
                <td><?php echo htmlspecialchars($row['DUE_DATE']); ?></td>
                <td><?php echo htmlspecialchars($row['RETURN_DATE'] ? $row['RETURN_DATE'] : 'Not Returned'); ?></td>
                <td><?php echo htmlspecialchars($row['FINE_AMOUNT']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>

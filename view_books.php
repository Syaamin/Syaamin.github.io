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

// Fetch search query if it exists
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Fetch books
$sql = "SELECT * FROM book";
if ($search) {
    $sql .= " WHERE BOOK_TITLE LIKE '%$search%' OR BOOK_AUTHOR LIKE '%$search%' OR BOOK_GENRE LIKE '%$search%' OR BOOK_CODE LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
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
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .book-image {
            max-width: 100px;
            max-height: 150px;
            height: auto;
            width: auto;
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
        <h2>View Books</h2>
        <form class="search-form" method="GET" action="">
            <input type="text" name="search" placeholder="Search for books..." value="<?php echo htmlspecialchars($search); ?>">
            <input type="submit" value="Search">
        </form>
        <table>
            <tr>
                <th>Book Code</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['BOOK_CODE']); ?></td>
                    <td><?php echo htmlspecialchars($row['BOOK_TITLE']); ?></td>
                    <td><?php echo htmlspecialchars($row['BOOK_AUTHOR']); ?></td>
                    <td><?php echo htmlspecialchars($row['BOOK_PRICE']); ?></td>
                    <td><?php echo htmlspecialchars($row['BOOK_YEAR']); ?></td>
                    <td><?php echo htmlspecialchars($row['BOOK_GENRE']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['BOOK_IMAGE']); ?>" class="book-image" alt="Book Image"></td>
                    <td class="action-links">
						<form method="POST" action="borrow_books.php">
							<input type="hidden" name="book_code" value="<?php echo htmlspecialchars($row['BOOK_CODE']); ?>">
							<button type="submit" class="borrow-link" title="Borrow">Borrow</button>
						</form>
					</td>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No books found</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>

</body>
</html>
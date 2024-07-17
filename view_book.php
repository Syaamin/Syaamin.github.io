<?php
include("config.php");
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
            background-color: #4CAF50;
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
            height: auto;
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
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Sidebar styles */
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>LIBRIFY</h2>
        <a href="home_admin.php">Home</a>
        <a href="add_book.php">Add Book</a>
        <a href="view_book.php">View Book</a>
        <a href="view_br.php">View History</a>
		<a href="logout.php">Logout</a>
    </div>

    <!-- Page content -->
    <div class="content">
        <div class="container">
            <h2>View Books</h2>
            <form class="search-form" method="GET" action="">
                <input type="text" name="search" placeholder="Search for books..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
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
                <?php
                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
                $sql = "SELECT * FROM book";
                if ($search) {
                    $sql .= " WHERE BOOK_TITLE LIKE '%$search%' OR BOOK_AUTHOR LIKE '%$search%' OR BOOK_GENRE LIKE '%$search%'";
                }
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['BOOK_CODE'] . "</td>";
                        echo "<td>" . $row['BOOK_TITLE'] . "</td>";
                        echo "<td>" . $row['BOOK_AUTHOR'] . "</td>";
                        echo "<td>" . $row['BOOK_PRICE'] . "</td>";
                        echo "<td>" . $row['BOOK_YEAR'] . "</td>";
                        echo "<td>" . $row['BOOK_GENRE'] . "</td>";
                        echo "<td><img src='" . $row['BOOK_IMAGE'] . "' alt='" . $row['BOOK_TITLE'] . "' class='book-image'></td>";
                        echo "<td class='action-links'>";
                        echo "<a href='edit.php?book_code=" . $row['BOOK_CODE'] . "' class='edit-link' title='Edit'>Edit</a>";
                        echo "<a href='delete.php?book_code=" . $row['BOOK_CODE'] . "' class='delete-link' title='Delete'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No books found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

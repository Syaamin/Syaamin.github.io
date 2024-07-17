<?php
include("config.php");

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch search query if it exists
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Fetch all borrowed and returned books with fine information
$sql = "SELECT br.borrow_id, br.borrow_date, br.return_date, br.fine_amount, b.book_code, b.book_title, s.username 
        FROM set_of_borrow br
        JOIN book b ON br.book_code = b.book_code
        JOIN student s ON br.stu_id = s.STU_ID";

if ($search) {
    $sql .= " WHERE s.username LIKE '%$search%' OR b.book_code LIKE '%$search%' OR b.book_title LIKE '%$search%'";
}

$sql .= " ORDER BY br.borrow_id ASC";

$result = $conn->query($sql);
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
            background-color: #4658F8;
        }
        .content {
            margin-left: 320px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Sidebar/menu -->
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
        <h2>View Borrowed and Returned Books</h2>
        <form class="search-form" method="GET" action="">
            <input type="text" name="search" placeholder="Search by username, book code, or book title..." value="<?php echo htmlspecialchars($search); ?>">
            <input type="submit" value="Search">
        </form>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Borrow ID</th>
                        <th>Student Username</th>
                        <th>Book Code</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Fine Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['borrow_id'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['book_code'] . "</td>";
                            echo "<td>" . $row['book_title'] . "</td>";
                            echo "<td>" . $row['borrow_date'] . "</td>";
                            echo "<td>" . $row['return_date'] . "</td>";
                            echo "<td>" . ($row['fine_amount'] ? $row['fine_amount'] : 'No Fine') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No borrowed and returned books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

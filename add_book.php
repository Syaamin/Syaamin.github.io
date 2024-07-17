<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book</title>
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
            flex: 1;
            margin-left: 320px; /* Adjusted for sidebar width + padding */
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        input[type=text], input[type=number], input[type=file], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type=submit]:hover {
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
                margin-left: 0; /* Adjusted for sidebar width + padding */
                padding: 20px;
                background-color: #f0f0f0;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
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
            <h2>Add Book</h2>
            <form id="addBookForm" method="post" action="add_book_process.php" enctype="multipart/form-data">
                <label for="book_code">Book Code:</label>
                <input type="text" id="book_code" name="book_code" required>

                <label for="book_title">Book Title:</label>
                <input type="text" id="book_title" name="book_title" required>

                <label for="book_author">Author:</label>
                <input type="text" id="book_author" name="book_author" required>

                <label for="book_price">Price:</label>
                <input type="number" step="0.01" id="book_price" name="book_price" required>

                <label for="book_year">Year:</label>
                <input type="number" id="book_year" name="book_year" required>

                <label for="book_genre">Genre:</label>
                <select id="book_genre" name="book_genre" required>
                    <option value="">Select a genre</option>
					<option value="Action">Action</option>
					<option value="Adventure">Adventure</option>
					<option value="Comedy">Comedy</option>
					<option value="Fantasy">Fantasy</option>
					<option value="Horror">Horror</option>
					<option value="Mystery">Mystery</option>
                    <option value="Non-Fiction">Non-Fiction</option>
					<option value="Romance">Romance</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Thriller">Thriller</option>
                </select>

                <label for="book_image">Book Image:</label>
                <input type="file" id="book_image" name="book_image" accept="image/*" required>

                <input type="submit" value="Add Book">
            </form>
        </div>
    </div>
</body>
</html>

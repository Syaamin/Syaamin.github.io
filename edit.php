<?php
include("config.php");

if (isset($_GET['book_code'])) {
    $book_code = $_GET['book_code'];

    $sql = "SELECT * FROM book WHERE BOOK_CODE = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $book_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_price = $_POST['book_price'];
    $book_year = $_POST['book_year'];
    $book_genre = $_POST['book_genre'];
    $book_image = $book['BOOK_IMAGE']; // Default to current image

    // Handle image upload
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['book_image']['name']);
        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $target_file)) {
            $book_image = $target_file;
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }

    $sql = "UPDATE book SET BOOK_TITLE = ?, BOOK_AUTHOR = ?, BOOK_PRICE = ?, BOOK_YEAR = ?, BOOK_GENRE = ?, BOOK_IMAGE = ? WHERE BOOK_CODE = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisss", $book_title, $book_author, $book_price, $book_year, $book_genre, $book_image, $book_code);

    if ($stmt->execute()) {
        // Redirect to view_book.php after successful update
        header("Location: view_book.php");
        exit;
    } else {
        echo "Error updating book: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        input[type=text], input[type=number], input[type=file] {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Book</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="book_code">Book Code:</label>
            <input type="text" id="book_code" name="book_code" value="<?php echo htmlspecialchars($book['BOOK_CODE']); ?>" readonly>

            <label for="book_title">Book Title:</label>
            <input type="text" id="book_title" name="book_title" value="<?php echo htmlspecialchars($book['BOOK_TITLE']); ?>" required>

            <label for="book_author">Author:</label>
            <input type="text" id="book_author" name="book_author" value="<?php echo htmlspecialchars($book['BOOK_AUTHOR']); ?>" required>

            <label for="book_price">Price:</label>
            <input type="number" step="0.01" id="book_price" name="book_price" value="<?php echo htmlspecialchars($book['BOOK_PRICE']); ?>" required>

            <label for="book_year">Year:</label>
            <input type="number" id="book_year" name="book_year" value="<?php echo htmlspecialchars($book['BOOK_YEAR']); ?>" required>

            <label for="book_genre">Genre:</label>
            <input type="text" id="book_genre" name="book_genre" value="<?php echo htmlspecialchars($book['BOOK_GENRE']); ?>" required>

            <label for="book_image">Book Image:</label>
            <input type="file" id="book_image" name="book_image" accept="image/*">

            <input type="submit" value="Update Book">
        </form>
    </div>
</body>
</html>
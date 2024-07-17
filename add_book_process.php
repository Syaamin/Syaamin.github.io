<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_code = $_POST['book_code'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_price = $_POST['book_price'];
    $book_year = $_POST['book_year'];
    $book_genre = $_POST['book_genre'];
    
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

    $sql = "INSERT INTO book (BOOK_CODE, BOOK_TITLE, BOOK_AUTHOR, BOOK_PRICE, BOOK_YEAR, BOOK_GENRE, BOOK_IMAGE)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdiss", $book_code, $book_title, $book_author, $book_price, $book_year, $book_genre, $book_image);

    if ($stmt->execute()) {
        // Close statement
        $stmt->close();
        
        // Redirect to view_book page after successful insertion
        echo '<script>alert("New book added successfully");</script>';
        echo '<script>window.location.href = "view_book.php";</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

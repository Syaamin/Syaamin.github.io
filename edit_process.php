<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id']; // Assuming you have the book_id passed via POST
    $book_code = $_POST['book_code'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_price = $_POST['book_price'];
    $book_year = $_POST['book_year'];
    $book_genre = $_POST['book_genre'];
    $book_image = '';

    // Handle image upload
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["book_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["book_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_file)) {
                $book_image = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        } else {
            echo "File is not an image.";
            exit();
        }
    }

    // Construct SQL query based on whether an image is uploaded or not
    if ($book_image != '') {
        $sql = "UPDATE books SET BOOK_CODE=?, BOOK_TITLE=?, BOOK_AUTHOR=?, BOOK_PRICE=?, BOOK_YEAR=?, BOOK_GENRE=?, BOOK_IMAGE=? WHERE BOOK_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdissi", $book_code, $book_title, $book_author, $book_price, $book_year, $book_genre, $book_image, $book_id);
    } else {
        $sql = "UPDATE books SET BOOK_CODE=?, BOOK_TITLE=?, BOOK_AUTHOR=?, BOOK_PRICE=?, BOOK_YEAR=?, BOOK_GENRE=? WHERE BOOK_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdissi", $book_code, $book_title, $book_author, $book_price, $book_year, $book_genre, $book_id);
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Close statement
        $stmt->close();

        // Display JavaScript alert for successful update
        echo '<script>alert("Updated successfully");</script>';
        // Redirect to view_book page after showing the alert
        echo '<script>window.location.href = "view_book.php";</script>';
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
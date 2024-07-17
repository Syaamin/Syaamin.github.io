<?php
include("config.php");

// Check if book_code is provided and exists in GET parameters
if (isset($_GET['book_code'])) {
    $book_code = $_GET['book_code'];

    // Check if action is set to delete
    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        $sql = "DELETE FROM book WHERE BOOK_CODE = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $book_code);

        if ($stmt->execute()) {
            // Book deleted successfully
            echo '<script>alert("Book deleted successfully.");</script>';
            echo '<script>window.location.href = "view_book.php";</script>';
            exit;
        } else {
            // Error deleting record
            echo "Error deleting record: " . $conn->error;
            exit;
        }
    } else {
        // Display JavaScript confirmation dialog
        echo '<script>';
        echo 'if (confirm("Are you sure you want to delete this book?")) {';
        echo '    window.location.href = "delete.php?action=delete&book_code=' . urlencode($book_code) . '";';
        echo '} else {';
        echo '    window.location.href = "view_book.php";'; // Redirect to view_book.php if cancel is clicked
        echo '}';
        echo '</script>';
    }

} else {
    // Book code not provided
    echo "Invalid request. Book code not provided.";
}
?>

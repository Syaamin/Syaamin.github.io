<?php
include("config.php");

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $book_code = $_POST['book_code'];
    $stu_id = $_SESSION['user_id'] ?? ''; // Ensure user ID is retrieved safely

    if (empty($stu_id)) {
        // Redirect or handle unauthorized access
        header("Location: login.php");
        exit();
    }

    // Calculate borrow date (Malaysia timezone assumed)
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $borrow_date = date('Y-m-d');
    $due_date = date('Y-m-d', strtotime($borrow_date . ' + 7 days'));

    // Check if the book is already borrowed and not returned
    $check_sql = "SELECT * FROM set_of_borrow WHERE BOOK_CODE = ? AND RETURN_DATE IS NULL";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $book_code);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Book is already borrowed
        ?>
        <script>
            alert("This book is already borrowed.");
            window.location.href = 'view_books.php'; // Redirect back to view_books.php
        </script>
        <?php
        exit(); // Exit PHP execution after displaying the alert
    } else {
        // Insert the borrowing record into the database
        $sql = "INSERT INTO set_of_borrow (BOOK_CODE, STU_ID, BORROW_DATE, DUE_DATE) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $book_code, $stu_id, $borrow_date, $due_date);

        if ($stmt->execute()) {
            // Book borrowed successfully
            ?>
            <script>
                alert("Book borrowed successfully! Due date: <?php echo $due_date; ?>");
                window.location.href = 'view_borrow.php'; // Redirect to view_borrow.php after successful borrowing
            </script>
            <?php
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if accessed directly without POST data
    header("Location: view_books.php");
    exit();
}
?>

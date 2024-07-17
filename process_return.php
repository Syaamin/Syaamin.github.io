<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
include("config.php");

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_code = $_POST['book_code'];
    $return_date = $_POST['return_date']; // Get return date from form input
    $stu_id = $_SESSION['user_id'];

    // Validate the return date
    $today = new DateTime(); // Today's date
    $return_date_obj = DateTime::createFromFormat('Y-m-d', $return_date);
    $today->setTime(0, 0); // Reset time to midnight for accurate comparison

    if (!$return_date_obj || $return_date_obj < $today) {
        echo '<script>alert("Invalid return date. Please select a date equal to or after today."); window.location = "return_books.php";</script>';
        exit;
    }

    // Check if the book is borrowed and not yet returned
    $select_sql = "SELECT DUE_DATE FROM set_of_borrow  
                   WHERE BOOK_CODE = ? 
                   AND STU_ID = ? 
                   AND RETURN_DATE IS NULL";
    $stmt_select = $conn->prepare($select_sql);
    $stmt_select->bind_param("ii", $book_code, $stu_id);
    $stmt_select->execute();
    $stmt_select->bind_result($due_date);
    $stmt_select->fetch();
    $stmt_select->close();

    if (empty($due_date)) {
        echo '<script>alert("No borrowed book found to return or it has already been returned."); window.location = "return_books.php";</script>';
        exit();
    }

    $due_date_obj = DateTime::createFromFormat('Y-m-d', $due_date);
    $fine_amount = 0.00;

    if ($return_date_obj > $due_date_obj) {
        $interval = $return_date_obj->diff($due_date_obj);
        $days_diff = $interval->days;
        $fine_amount = $days_diff * 0.10;
    }

    // Update the return date and fine amount
    $update_sql = "UPDATE set_of_borrow 
                   SET RETURN_DATE = ?, FINE_AMOUNT = ? 
                   WHERE BOOK_CODE = ? 
                   AND STU_ID = ? 
                   AND RETURN_DATE IS NULL";

    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("ssii", $return_date, $fine_amount, $book_code, $stu_id);

    if ($stmt_update->execute()) {
        if ($stmt_update->affected_rows > 0) {
            echo '<script>alert("Book returned successfully! Fine of RM ' . number_format($fine_amount, 2) . ' applied."); window.location = "view_borrow.php";</script>';
        } else {
            echo '<script>alert("No borrowed book found to return or it has already been returned."); window.location = "return_books.php";</script>';
        }
    } else {
        echo "Error updating return date: " . $stmt_update->error;
    }

    $stmt_update->close();
    $conn->close();
}
?>

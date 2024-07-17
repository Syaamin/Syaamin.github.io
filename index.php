<?php
include("header.php");
include("config.php");

// Fetch books grouped by genre
$sql = "SELECT BOOK_GENRE, BOOK_TITLE, BOOK_IMAGE FROM book ORDER BY BOOK_GENRE, BOOK_TITLE";
$result = $conn->query($sql);

$booksByGenre = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $booksByGenre[$row['BOOK_GENRE']][] = $row;
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        color: #333;
        text-align: center;
        padding: 20px;
    }
    .welcome {
        margin-bottom: 30px;
    }
    .welcome h2 {
        color: #4CAF50;
        margin-bottom: 10px;
    }
    .section {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: left;
    }
    .section h2 {
        margin-bottom: 10px;
        cursor: pointer;
    }
    .section h2 a {
        color: #4CAF50;
        text-decoration: none;
    }
    .section p {
        font-size: 16px;
        line-height: 1.6;
    }
    .books-by-genre {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .genre-section {
        width: 100%;
        margin-bottom: 20px;
    }
    .genre-title {
        color: #4CAF50;
        margin-bottom: 10px;
    }
    .book {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        text-align: center;
        width: calc(25% - 20px); /* Adjusted width to fit 4 books per row */
        box-sizing: border-box;
    }
    .book img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        max-height: 150px;
        object-fit: cover;
    }
    .book-title {
        margin-top: 10px;
        font-size: 14px;
    }
    .btn {
        display: inline-block;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    .btn:hover {
        background-color: #45a049;
    }
</style>

<div class="welcome">
    <h2>Welcome to LIBRIFY</h2>
    <p>Your one-stop online library for books, journals, and more.</p>
</div>

<div class="section">
    <h2>Our Collection</h2>
    <p>Immerse yourself with the books.</p>
    
    <?php foreach ($booksByGenre as $genre => $books): ?>
    <div class="genre-section">
        <h3 class="genre-title"><?php echo htmlspecialchars($genre); ?></h3>
        <div class="books-by-genre">
            <?php foreach ($books as $book): ?>
            <div class="book">
                <img src="<?php echo htmlspecialchars($book['BOOK_IMAGE']); ?>" class="book-image" alt="Book Image">
                <div class="book-title"><?php echo htmlspecialchars($book['BOOK_TITLE']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

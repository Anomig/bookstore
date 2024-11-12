<?php
session_start();
include_once __DIR__ . "/classes/Db.php";
include_once __DIR__ . "/classes/Books.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect niet-admin gebruikers
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Maak databaseverbinding
    $db = Db::getConnection();
    $book = new Book($db);

    // Zet de boekgegevens via setters
    $book->setTitle($_POST['title']);
    $book->setAuthor($_POST['author']);
    $book->setDescription($_POST['description']);
    $book->setPrice($_POST['price']);
    $book->setImageUrl($_POST['image_url']);
    $book->setType($_POST['type']);
    $book->setCategoryId($_POST['category_id']);

    // Voeg het boek toe
    if ($book->addBook()) {
        echo "Book added successfully!";
    } else {
        echo "Failed to add book.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
</head>
<body>
    <h2>Add New Book</h2>
    <form action="" method="post">
        <label>Title:</label>
        <input type="text" name="title" required><br>

        <label>Author:</label>
        <input type="text" name="author" required><br>

        <label>Description:</label>
        <textarea name="description" required></textarea><br>

        <label>Price:</label>
        <input type="text" name="price" required><br>

        <label>Image URL:</label>
        <input type="text" name="image_url"><br>

        <label>Type:</label>
        <select name="type" required>
            <option value="fysiek boek">Fysiek boek</option>
            <option value="ebook">eBook</option>
            <option value="audioboek">Audioboek</option>
            <option value="tijdschrift">Tijdschrift</option>
        </select><br>

        <label>Category ID:</label>
        <input type="number" name="category_id" required><br>

        <input type="submit" value="Add Book">
    </form>
</body>
</html>

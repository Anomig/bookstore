<?php
session_start();
include_once __DIR__ . "/classes/Db.php";
include_once __DIR__ . "/classes/Books.php";
include_once __DIR__ . "/classes/Category.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect niet-admin gebruikers
    header('Location: login.php');
    exit();
}

$db = Db::getConnection();
$category = new Category($db);
$categories = $category->getAllCategories(); // Haal alle categorieën op

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Maak boek object
    $book = new Book($db);

    // Zet de boekgegevens via setters met validatie en sanitatie
    try {
        $book->setTitle(htmlspecialchars(trim($_POST['title'])));
        $book->setAuthor(htmlspecialchars(trim($_POST['author'])));
        $book->setDescription(htmlspecialchars(trim($_POST['description'])));
        $book->setPrice(floatval($_POST['price']));
        $book->setImageUrl(filter_var($_POST['image_url'], FILTER_VALIDATE_URL));
        $book->setType($_POST['type']);
        $book->setCategoryId(intval($_POST['category_id']));

        // Voeg het boek toe
        if ($book->addBook()) {
            header("Location: book_list.php"); // Redirect naar de lijst van boeken
            exit();
        } else {
            $error_message = "Failed to add book.";
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage(); // Toon foutmelding
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

    <?php if (isset($error_message)): ?>
        <div style="color: red;">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>

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

        <label>Category:</label>
        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Add Book">
    </form>
</body>
</html>

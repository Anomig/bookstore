<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once './classes/Users.php';
include_once './classes/Books.php';
include_once './classes/Db.php';

session_start();

// Controleer of de gebruiker ingelogd is en of deze een admin is
if ($_SESSION['login'] !== true || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$db = Db::getConnection();
$book = new Book($db);

// Haal het product op dat bewerkt moet worden
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Product niet gevonden!";
        exit();
    }
}

// Update het product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validatie van de invoer
    if (!is_numeric($_POST['price']) || $_POST['price'] <= 0) {
        echo "De prijs moet een positief getal zijn.";
    } else {
        // Gebruik de setters om de waarden in het Book-object in te stellen
        $book->setId($_POST['id']);
        $book->setTitle($_POST['title']);
        $book->setAuthor($_POST['author']);
        $book->setDescription($_POST['description']);
        $book->setPrice($_POST['price']);
        $book->setImageUrl($_POST['image_url']);
        $book->setType($_POST['type']);
        $book->setCategoryId($_POST['category_id']);

        // Update de gegevens
        if ($book->update()) {
            echo "Product succesvol bijgewerkt!";
        } else {
            echo "Er is een fout opgetreden bij het bijwerken van het product.";
        }
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Bewerk product</h1>

    <form method="POST">
    <input type="hidden" name="id" value="<?= $product['id']; ?>">

    <label for="title">Titel:</label>
    <input type="text" name="title" id="title" value="<?= $product['title']; ?>" required><br>

    <label for="author">Auteur:</label>
    <input type="text" name="author" id="author" value="<?= $product['author']; ?>" required><br>

    <label for="description">Beschrijving:</label>
    <textarea name="description" id="description" required><?= $product['description']; ?></textarea><br>

    <label for="price">Prijs:</label>
    <input type="number" name="price" id="price" value="<?= $product['price']; ?>" required><br>

    <label for="image_url">Afbeelding URL:</label>
    <input type="text" name="image_url" id="image_url" value="<?= $product['image_url']; ?>" required><br>

    <label for="type">Type:</label>
    <select name="type" id="type" required>
        <option value="fysiek boek" <?= $product['type'] == 'fysiek boek' ? 'selected' : ''; ?>>Fysiek boek</option>
        <option value="ebook" <?= $product['type'] == 'ebook' ? 'selected' : ''; ?>>E-book</option>
        <option value="audioboek" <?= $product['type'] == 'audioboek' ? 'selected' : ''; ?>>Audioboek</option>
    </select><br>

    <label for="category_id">Categorie:</label>
    <select name="category_id" id="category_id" required>
        <?php 
        // Haal de categorieën op
        $stmt = $db->query("SELECT id, name FROM categories");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                <?= $category['name']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit">Werk product bij</button>
</form>

</body>
</html>

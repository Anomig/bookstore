<?php
// Voeg zoek- en filterfunctionaliteit toe
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

// Verkrijg zoek- en filterparameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';

// Haal de producten op met de zoek- en filtercriteria
$query = "SELECT * FROM products WHERE title LIKE :search";
$params = ['search' => "%$search%"];

if ($category_filter) {
    $query .= " AND category_id = :category";
    $params['category'] = $category_filter;
}

if ($type_filter) {
    $query .= " AND type = :type";
    $params['type'] = $type_filter;
}

$stmt = $db->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Haal de categorieën op voor het filteren
$categories_stmt = $db->query("SELECT id, name FROM categories");
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beheer Producten</title>
</head>
<body>
    <h1>Beheer Producten</h1>

    <!-- Zoeken en Filteren Formulier -->
    <form method="GET">
        <input type="text" name="search" placeholder="Zoek op titel" value="<?= $search ?>">
        
        <label for="category">Categorie:</label>
        <select name="category">
            <option value="">Alle Categorieën</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id']; ?>" <?= $category['id'] == $category_filter ? 'selected' : ''; ?>><?= $category['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="type">Type:</label>
        <select name="type">
            <option value="">Alle Types</option>
            <option value="fysiek boek" <?= $type_filter == 'fysiek boek' ? 'selected' : ''; ?>>Fysiek boek</option>
            <option value="ebook" <?= $type_filter == 'ebook' ? 'selected' : ''; ?>>E-book</option>
            <option value="audioboek" <?= $type_filter == 'audioboek' ? 'selected' : ''; ?>>Audioboek</option>
        </select>

        <button type="submit">Zoeken</button>
    </form>

    <!-- Producten Weergeven -->
    <table>
        <tr>
            <th>Titel</th>
            <th>Auteur</th>
            <th>Prijs</th>
            <th>Type</th>
            <th>Categorie</th>
            <th>Acties</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['title']; ?></td>
            <td><?= $product['author']; ?></td>
            <td><?= $product['price']; ?></td>
            <td><?= $product['type']; ?></td>
            <td><?= $product['category_id']; ?></td>
            <td>
                <a href="edit_product.php?id=<?= $product['id']; ?>">Bewerken</a> |
                <a href="delete_product.php?id=<?= $product['id']; ?>">Verwijderen</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

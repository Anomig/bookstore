<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit();
}

include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Users.php");
include_once(__DIR__ . "/classes/Books.php");
include_once(__DIR__ . "/classes/Category.php");

$db = Db::getConnection();

// Instantieer de classes
$book = new Book($db);
$category = new Category($db);

// Haal categorieën op
$categories_stmt = $db->query("SELECT id, name FROM categories");
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

$category_filter = isset($_GET['category']) ? $_GET['category'] : ''; // Zorg ervoor dat category_filter altijd gedefinieerd is

// Haal de producten op die behoren tot de geselecteerde categorie (indien geselecteerd)
if ($category_filter) {
    $stmt = $db->prepare("SELECT * FROM products WHERE category_id = :category_id");
    $stmt->execute(['category_id' => $category_filter]);
} else {
    // Haal alle producten op als er geen categorie is geselecteerd
    $stmt = $db->query("SELECT * FROM products");
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$books = $book->read($filter_category); // Pas je `getAllBooks` methode aan om filters te ondersteunen
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <h1>Welcome to the shop!</h1>

    <form method="GET" action="index.php">
    <select name="category_id">
        <option value="">Alle Categorieën</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id']; ?>" <?= isset($category_filter) && $category_filter == $cat['id'] ? 'selected' : ''; ?>>
                <?= $cat['name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Filteren">
    </form>

    <div class="container">
        <div class="product-grid">
            <?php foreach ($books as $product): ?>
                <div class="product">
                    <img src="<?$product['image_url']; ?>" alt="<?=$product['title']; ?>">
                    <div class="product-info">
                        <h3><?= $product['title']; ?></h3>
                        <p><?= $product['author']; ?></p>
                        <p class="price"><?$product['price'];?>€</p>
                        <a href="add_to_cart.php?id=<?= $product['id'];?>" class="btn-add-to-cart">Add to cart</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <a href="logout.php">logout?</a>
</body>
</html>
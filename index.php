<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include_once(__DIR__ . "/classes/Db.php");
    include_once(__DIR__ . "/classes/Users.php");
    include_once(__DIR__ . "/classes/Books.php");
    include_once(__DIR__ . "/classes/Category.php");

    
    if($_SESSION['login'] !== true){                                        // als de persoon niet is ingelogd, ga naar login.php    
        header('Location: login.php');
    }

    $db = Db::getConnection();

    // Instantieer de classes
$book = new Book($db);
$category = new Category($db);

// Haal categorieën op
$categories = $category->getAllCategories(); // Dit geeft een array

// Haal boeken op, eventueel gefilterd op categorie
$filter_category = isset($_GET['category_id']) ? $_GET['category_id'] : null;
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
            <option value="<?= $cat['id']; ?>" <?= isset($filter_category) && $filter_category == $cat['id'] ? 'selected' : ''; ?>>
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
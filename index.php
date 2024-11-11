<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
    include_once './classes/Users.php';
    include_once './classes/Books.php';
    include_once './classes/Db.php';

    session_start();
    if($_SESSION['login'] !== true){                                        // als de persoon niet is ingelogd, ga naar login.php    
        header('Location: login.php');
    }

    $db = Db::getConnection();

    $book = new Book($db);
    $stmt = $book->read();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
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
include_once(__DIR__ . "/classes/Books.php");

$db = Db::getConnection();
$book = new Book($db);

// Haal alle product-ID's op uit de sessie winkelmandje
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart_product_ids = implode(',', $_SESSION['cart']); // Maak een komma-gescheiden lijst van product-IDs
    $stmt = $db->query("SELECT * FROM products WHERE id IN ($cart_product_ids)");
    $cart_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $cart_products = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmandje</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <h1>Jouw Winkelmandje</h1>

    <?php if (empty($cart_products)): ?>
        <p>Je winkelmandje is leeg!</p>
    <?php else: ?>
        <div class="container">
            <div class="product-grid">
                <?php foreach ($cart_products as $product): ?>
                    <div class="product">
                        <img src="<?= $product['image_url']; ?>" alt="<?= $product['title']; ?>">
                        <div class="product-info">
                            <h3><?= $product['title']; ?></h3>
                            <p><?= $product['author']; ?></p>
                            <p class="price"><?= $product['price']; ?>€</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cart-summary">
                <h3>Winkelmandje Totaal: 
                <?php 
                $total_price = 0;
                foreach ($cart_products as $product) {
                    $total_price += $product['price'];
                }
                echo $total_price . '€';
                ?>
                </h3>
                <a href="checkout.php" class="btn-checkout">Doorgaan naar Afrekenen</a>
            </div>
        </div>
    <?php endif; ?>
    
    <a href="index.php">Terug naar de winkel</a>
</body>
</html>

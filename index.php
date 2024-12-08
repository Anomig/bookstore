<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit();
}

// Winkelmandje-functionaliteit
if (isset($_GET['action']) && $_GET['action'] == 'add_to_cart' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Controleer of het winkelmandje al bestaat in de sessie
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Voeg het product toe aan het winkelmandje
    if (!in_array($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_id; // Voeg het product toe als het nog niet in het winkelmand zit
    }
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

// Haal de zoekterm op
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Haal de categoriefilter op
$category_filter = isset($_GET['category']) ? $_GET['category'] : ''; 

// Haal de producten op die voldoen aan de zoekterm en de categorie (indien geselecteerd)
$query = "SELECT * FROM products WHERE (title LIKE :search OR description LIKE :search)";
$params = ['search' => '%' . $search_term . '%'];

if ($category_filter) {
    $query .= " AND category_id = :category_id";
    $params['category_id'] = $category_filter;
}

$stmt = $db->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="header">
        <div class="logo">Bookstore</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>


    <h1>Welcome to the shop!</h1>

    <!-- Zoekformulier -->
    <form method="GET" action="index.php" style="display: flex; justify-content: center; margin-bottom: 30px;">
        <input type="text" name="search" placeholder="Zoek naar een product..." value="<?= htmlspecialchars($search_term); ?>" style="padding: 10px; font-size: 1.1rem;">
        <input type="submit" value="Zoeken" style="background-color: #ff6600; color: white; font-size: 1.1rem; padding: 10px 20px; cursor: pointer;">
    </form>

    <!-- Filteren op Categorie -->
    <form method="GET" action="index.php" style="display: flex; justify-content: center; margin-bottom: 30px;">
        <select name="category" style="padding: 10px; font-size: 1.1rem;">
            <option value="">Alle Categorieën</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>" <?= $category_filter == $cat['id'] ? 'selected' : ''; ?>>
                    <?= $cat['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Filteren" style="background-color: #ff6600; color: white; font-size: 1.1rem; padding: 10px 20px; cursor: pointer;">
    </form>

    <div class="container">
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="<?= $product['image_url']; ?>" alt="<?= $product['title']; ?>">
                    <div class="product-info">
                        <h3><?= $product['title']; ?></h3>
                        <p><?= $product['author']; ?></p>
                        <p class="price"><?= $product['price']; ?>€</p>
                        <a href="index.php?action=add_to_cart&id=<?= $product['id']; ?>" class="btn-add-to-cart">Add to cart</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <a href="logout.php">Logout?</a>
    <a href="cart.php">Cart</a>
</body>
</html>

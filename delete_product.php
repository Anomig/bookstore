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

// Bevestiging voor productverwijdering
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $product_id = $_GET['id'];
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$product_id])) {
        echo "Product verwijderd!";
    } else {
        echo "Er is een fout opgetreden bij het verwijderen.";
    }
} elseif (isset($_GET['id'])) {
    // Toon een bevestigingspagina voor het verwijderen van het product
    $product_id = $_GET['id'];
    echo "Weet je zeker dat je dit product wilt verwijderen? <a href='delete_product.php?id=$product_id&confirm=yes'>Ja</a> | <a href='manage_products.php'>Nee</a>";
}
?>

<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit();
}

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Hier kun je de betalings- en verzendgegevens toevoegen
// Voor nu simuleren we de bestelling en legen we het winkelmandje

unset($_SESSION['cart']); // Leeg het winkelmandje na succesvolle bestelling

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrekenen</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <h1>Bestelling Geplaatst</h1>
    <p>Bedankt voor je bestelling! Je winkelmandje is nu leeg.</p>
    <a href="index.php">Terug naar de winkel</a>
</body>
</html>

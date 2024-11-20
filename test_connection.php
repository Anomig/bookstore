<?php
$dsn = 'mysql:host=localhost;dbname=bookstore';
$username = 'root';
$password = 'root';

try {
    // Maak een verbinding met de database
    $pdo = new PDO($dsn, $username, $password);
    // Stel de foutmodus in op exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Verbinding succesvol!";
} catch (PDOException $e) {
    echo "Verbindingsfout: " . $e->getMessage();
}
?>

<?php
session_start(); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Als de gebruiker niet ingelogd is of geen admin is, doorsturen naar loginpagina
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="add_book.php">Add Book</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="content">
        <h2>Welcome, Admin!</h2>
        <p>Here you can manage your products.</p>
    </div>
</body>
</html>

<?php 

    session_start();
    if($_SESSION['login'] !== true){                                        // als de persoon niet is ingelogd, ga naar login.php    
        header('Location: login.php');
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to the shop!</h1>
    <a href="logout.php">logout?</a>
</body>
</html>
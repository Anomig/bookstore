<?php 
    include_once 'classes/Users.php';
    include_once 'classes/Db.php';

    // try{
    //         $conn = Db:: getConnection();
    //         echo "Connected to the database 🎉";
    //     } catch(PDOException $ex){
    //         echo "Not connected to the database 🙈" . $ex->getMessage();
    //     }

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
<?php
session_start(); 

// Controleer of de gebruiker is ingelogd als admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Als de gebruiker niet ingelogd is of geen admin is, doorsturen naar loginpagina
    header('Location: login.php');
    exit();
}

// Haal de naam van de ingelogde admin op voor gepersonaliseerd welkomstbericht
$admin_name = isset($_SESSION['fname']) ? $_SESSION['fname'] : 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
</head>
<body>
    <!-- Navigatiebalk -->
    <header>
        <div class="navbar">
            <div class="logo">
                <h1>Admin Dashboard</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="add_book.php">Add Book</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hoofdcontent -->
    <main>
        <div class="content">
            <h2>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
            <p class="welcome-message">Here you can manage your products, view orders, and more.</p>
        </div>
    </main>
</body>
</html>

<?php
session_start();
include_once __DIR__ . "/classes/Db.php";
include_once __DIR__ . "/classes/Books.php";
include_once __DIR__ . "/classes/Category.php";

// Controleer of de gebruiker een admin is
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect niet-admin gebruikers
    header('Location: login.php');
    exit();
}

$db = Db::getConnection();
$category = new Category($db);
$categories = $category->getAllCategories(); // Haal alle categorieën op

$error_message = ""; // Variabele voor foutmeldingen

// Verwerk formulier bij POST-aanroep
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Maak boek object
    $book = new Book($db);

    // Voeg boek toe vanuit formuliergegevens
    $error_message = $book->addBookFromPost($_POST);
    
    // Als er geen fout is, redirect naar admin dashboard
    if ($error_message === "") {
        header("Location: admin_dashboard.php"); // Redirect naar de lijst van boeken
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
    <title>Add New Book</title>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <h1>Admin Dashboard</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php" >Dashboard</a></li>
                    <li><a href="add_book.php" class="active">Add Book</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <h2>Add New Book</h2>

    <?php if (!empty($error_message)): ?>
        <div style="color: red;">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <label>Title:</label>
        <input type="text" name="title" required><br>

        <label>Author:</label>
        <input type="text" name="author" required><br>

        <label>Description:</label>
        <input type="text" name="description" required></input><br>

        <label>Price:</label>
        <input type="text" name="price" required><br>

        <label>Image URL:</label>
        <input type="text" name="image_url"><br>

        <label>Type:</label>
        <select name="type" required>
            <option value="fysiek boek">Fysiek boek</option>
            <option value="ebook">eBook</option>
            <option value="audioboek">Audioboek</option>
            <option value="tijdschrift">Tijdschrift</option>
        </select><br>

        <label>Category:</label>
        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Add Book">
    </form>
</body>
</html>

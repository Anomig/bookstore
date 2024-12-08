<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include_once './classes/Db.php';
include_once './classes/Books.php';

$db = Db::getConnection();
$book = new Book($db);
$books = $book->read(); // Haal alle boeken op

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
    <title>Manage Products</title>
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
                    <li><a href="add_book.php" >Add Book</a></li>
                    <li><a href="manage_products.php" class="active">Manage Products</a></li>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <h1>Manage Products</h1>

    <div class="content">
    <?php if (count($books) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= $book['title']; ?></td>
                        <td><?= $book['author']; ?></td>
                        <td><?= $book['price']; ?>€</td>
                        <td>
                            <a href="edit_product.php?id=<?= $book['id']; ?>">Edit</a>
                            <a href="delete_product.php?id=<?= $book['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>
</body>
</html>

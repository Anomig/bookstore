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
    <title>Manage Products</title>
</head>
<body>
    <h1>Manage Products</h1>

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
</body>
</html>

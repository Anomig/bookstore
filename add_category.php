<?php
include_once 'Db.php';
include_once 'Category.php';

$db = Db::getConnection();
$category = new Category($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));

    if ($category->addCategory($name, $description)) {
        echo "Categorie toegevoegd!";
    } else {
        echo "Er is iets mis gegaan!";
    }
}
?>

<form action="add_category.php" method="POST">
    <label>Category Name:</label>
    <input type="text" name="name" placeholder="Categorie naam" required><br>

    <label>Description:</label>
    <textarea name="description" placeholder="Beschrijving van de categorie" required></textarea><br>

    <input type="submit" value="Categorie toevoegen">
</form>

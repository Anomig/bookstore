<?php
include_once 'Db.php';
include_once 'Category.php';

$db = Db::getConnection();
$category = new Category($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    if ($category->addCategory($name, $description)) {
        echo "Categorie toegevoegd!";
    } else {
        echo "Er is iets mis gegaan!";
    }
}
?>

<form action="add_category.php" method="POST">
    <input type="text" name="name" placeholder="Categorie naam" required>
    <textarea name="description" placeholder="Beschrijving van de categorie" required></textarea>
    <input type="submit" value="Categorie toevoegen">
</form>

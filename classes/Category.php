<?php
class Category {
    private $db;
    private $table = 'categories';

    public function __construct($db) {
        $this->db = $db;
    }

    // Voeg een nieuwe categorie toe
    public function addCategory($name, $description) {
        if (empty($name) || empty($description)) {
            throw new Exception("Name and description cannot be empty.");
        }

        $sql = "INSERT INTO " . $this->table . " (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        // Voer de query uit
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Haal alle categorieën op
    public function getAllCategories() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een categorie op op basis van de ID
    public function getCategoryById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

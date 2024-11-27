<?php
class Book {
    private $conn;
    private $table = "products";

    // Boeken eigenschappen (privé)
    private $id;
    private $title;
    private $author;
    private $description;
    private $price;
    private $image_url;
    private $type;
    private $category_id;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Getter en Setter voor de id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter en Setter voor de title
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        if (empty($title)) {
            throw new Exception("Title can't be empty");
        }
        $this->title = $title;
    }

    // Getter en Setter voor de author
    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        if (empty($author)) {
            throw new Exception("Author can't be empty");
        }
        $this->author = $author;
    }

    // Getter en Setter voor de description
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        if (empty($description)) {
            throw new Exception("Description can't be empty");
        }
        $this->description = $description;
    }

    // Getter en Setter voor de price
    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        if ($price <= 0) {
            throw new Exception("Price must be greater than 0");
        }
        $this->price = $price;
    }

    // Getter en Setter voor image_url
    public function getImageUrl() {
        return $this->image_url;
    }

    public function setImageUrl($image_url) {
        if (empty($image_url)) {
            throw new Exception("Image URL can't be empty");
        }
        $this->image_url = $image_url;
    }

    // Getter en Setter voor type
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    // Getter en Setter voor category_id
    public function getCategoryId() {
        return $this->category_id;
    }

    public function setCategoryId($category_id) {
        if (empty($category_id)) {
            throw new Exception("Category ID can't be empty");
        }
        $this->category_id = $category_id;
    }

    // Functie om alle boeken op te halen
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("No books found.");
        }
    }

    // Functie om een boek toe te voegen
    public function addBook() {
        $query = "INSERT INTO " . $this->table . " (title, author, description, price, image_url, type, category_id) 
                  VALUES (:title, :author, :description, :price, :image_url, :type, :category_id)";
        
        $stmt = $this->conn->prepare($query);

        // Bind de waarden aan de statement
        $stmt->bindValue(':title', $this->title);
        $stmt->bindValue(':author', $this->author);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':price', $this->price);
        $stmt->bindValue(':image_url', $this->image_url);
        $stmt->bindValue(':type', $this->type);
        $stmt->bindValue(':category_id', $this->category_id);

        // Voer het statement uit
        return $stmt->execute();
    }
    
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, author = :author, description = :description, 
                      price = :price, image_url = :image_url, type = :type, category_id = :category_id
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        // Bind de waarden aan de statement
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':category_id', $this->category_id);
        
        return $stmt->execute(); // Voer de query uit en geef het resultaat terug
    }
    
    // Functie om een boek te verwijderen (alleen admin)
    public function deleteBook() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $this->id);
        return $stmt->execute();
    }
}

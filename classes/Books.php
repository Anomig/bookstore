<?php
    class Book {
        private $conn;
        private $table = "products";  // Je database tabelnaam
    
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
            $this->title = $title;
        }
    
        // Getter en Setter voor de author
        public function getAuthor() {
            return $this->author;
        }
    
        public function setAuthor($author) {
            $this->author = $author;
        }
    
        // Getter en Setter voor de description
        public function getDescription() {
            return $this->description;
        }
    
        public function setDescription($description) {
            $this->description = $description;
        }
    
        // Getter en Setter voor de price
        public function getPrice() {
            return $this->price;
        }
    
        public function setPrice($price) {
            if ($price > 0) {  // Validatie: de prijs moet positief zijn
                $this->price = $price;
            } else {
                throw new Exception("Price must be greater than 0");
            }
        }
    
        // Getter en Setter voor image_url
        public function getImageUrl() {
            return $this->image_url;
        }
    
        public function setImageUrl($image_url) {
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
            $this->category_id = $category_id;
        }
    
        // Functie om alle boeken op te halen
        public function read() {
            $query = "SELECT * FROM " . $this->table;
            $stmt = $this->conn->query($query);
            return $stmt;
        }
    
        // Functie om een boek toe te voegen
        public function create() {
            $query = "INSERT INTO " . $this->table . " (title, author, description, price, image_url, type, category_id) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
    
            $stmt = $this->conn->prepare($query);
    
            // Bind de waarden aan de statement
            $stmt->bind_param("ssssssi", $this->title, $this->author, $this->description, $this->price, $this->image_url, $this->type, $this->category_id);
    
            if ($stmt->execute()) {
                return true;
            }
    
            return false;
        }
    }
    

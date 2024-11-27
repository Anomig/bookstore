<?php
include_once(__DIR__ . "/Db.php");

class User
{
    private $fname;
    private $lname;
    private $email;
    private $password;
    private $role = "user"; // Standaardrol is "user"
    private $currency = 1000; // Standaardcurrency bij registratie

    // Getters en setters
    public function getFname() { return $this->fname; }
    public function setFname($fname) {
        if (empty($fname)) throw new Exception("First name can't be empty.");
        $this->fname = $fname;
        return $this;
    }

    public function getLname() { return $this->lname; }
    public function setLname($lname) {
        if (empty($lname)) throw new Exception("Last name can't be empty.");
        $this->lname = $lname;
        return $this;
    }

    public function getEmail() { return $this->email; }
    public function setEmail($email) {
        if (empty($email)) throw new Exception("Email can't be empty.");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Invalid email format.");
        $this->email = $email;
        return $this;
    }

    public function getPassword() { return $this->password; }
    public function setPassword($password) {
        if (empty($password)) throw new Exception("Password can't be empty.");
        if (strlen($password) < 4) throw new Exception("Password must be at least 4 characters long.");
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getRole() { return $this->role; }
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    public function getCurrency() { return $this->currency; }
    public function setCurrency($currency) {
        if ($currency < 0) throw new Exception("Currency cannot be negative.");
        $this->currency = $currency;
        return $this;
    }

    // Controle of e-mail al bestaat
    public function emailExists() {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindValue(":email", $this->email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Opslaan van gebruiker
    public function save() {
        if ($this->emailExists()) {
            throw new Exception("This email is already registered.");
        }

        $conn = Db::getConnection();
        $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password, role, currency)
                                VALUES (:fname, :lname, :email, :password, :role, :currency)");
        $stmt->bindValue(":fname", $this->fname);
        $stmt->bindValue(":lname", $this->lname);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":password", $this->password);
        $stmt->bindValue(":role", $this->role);
        $stmt->bindValue(":currency", $this->currency);
        return $stmt->execute();
    }

    // Loginvalidatie
    public static function canLogin($email, $password) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }

    // Gebruikersgegevens ophalen
    public function getUserByEmail($email) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

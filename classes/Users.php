<?php
    include_once(__DIR__ . "/Db.php");

    Class User{
        private $fname;
        private $lname;
        private $email;
        private $password;
        private $role;

        public function getFname()
        {
            return $this->fname;
        }

        public function setFname($fname)
        {
            if(empty($fname)){
                throw new Exception("First name can't be empty");
            }
            $this->fname = $fname;
            return $this;
        }

        public function getLname()
        {
            return $this->lname;
        }

        public function setLname($lname)
        {
            if(empty($lname)){
                throw new Exception("Last name can't be empty");
            }
            $this->lname = $lname;
            return $this;
        }

        public function getEmail()
        {
                return $this->email;
        }

        public function setEmail($email)
        {
            if(empty($email)){
                throw new Exception("Email can't be empty");
            }
            $this->email = $email;
            return $this;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function setPassword($password)
        {
            if(empty($password)){
                throw new Exception("Password can't be empty");
            }
            $this->password = password_hash($password, PASSWORD_DEFAULT);
            return $this;
        }

        public function getRole()
        {
                return $this->role;
        }

        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }

        public function save(){
            $conn = db::getConnection();
            $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password) VALUES (:fname, :lname, :email, :password)");
            $stmt->bindValue(":fname", $this->fname);
            $stmt->bindValue(":lname", $this->lname);
            $stmt->bindValue(":email", $this->email);
            $stmt->bindValue(":password", $this->password);
            return $stmt->execute();
        }

        public static function canLogin($email,$password){
            $conn = db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();
            if($user === false){
                return false;
            }
            if(password_verify($password, $user['password'])){
                return true;
            }
        }

        public function getUserByEmail($email){
            $conn = db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
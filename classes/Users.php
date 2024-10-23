<?php
    include_once(__DIR__ . "/db.php");

    Class User{
        private $fname;
        private $lname;
        private $email;
        private $password;

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
            $this->password = $password;
            return $this;
        }

        public function save(){
            $conn = db::getConnection();
            $stmt = $conn->prepare("INSERT INTO users (fname, lname, email) VALUES (:fname, :lname, :email)");
            $stmt->bindValue(":fname", $this->fname);
            $stmt->bindValue(":lname", $this->lname);
            $stmt->bindValue(":email", $this->email);
            return $stmt->execute();
        }

        public static function canLogin(
            $email,
            $password
        ){
            $conn = db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $user = $stmt->fetch();
            if($user === false){
                return false;
            }
            if(password_verify($password, $user['password'])){
                return true;
            }
            return false;
        }
    }
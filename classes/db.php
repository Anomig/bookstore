<?php 
    abstract class db{
        private static $conn;

        public static function getConnection(){
            if(self::$conn === null){
                echo 'Connected to the database';
                self::$conn = new PDO('mysql:host=localhost;dbname=bookstore', 'root', 'root');
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }else{
            return self::$conn;
            }
        }
    }
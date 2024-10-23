<?php 
    class Db{
        private static $conn = null;

        public static function getConnection(){
            if(self::$conn == null){ //niet this want het is een static method dus self want je verwijst naar de class zelf. Deze lijn beschrijft dat als er nog geen connectie is, dat hij er een maakt
                echo "🙈";
                self::$conn = new PDO("mysql:host=localhost;dbname=bookstore", "root", "root");
                return self::$conn;
            }
            else{
                echo "🎉";
                return self::$conn;
            }
        }
    }

<?php
    class DB {
        private $host;
        private $db;
        private $user;
        private $pass;

        public function __construct() {
            $this-> host = 'localhost';
            $this-> db = 'AlquilerVehiculos';
            $this-> user = 'oscar';
            $this-> pass = 'contraseña';
        }

       public function connect() {
            try{
                $conn = "mysql:host=". $this->host .";dbname=". $this->db;

                $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_EMULATE_PREPARES => false];

                $pdo = new PDO($conn, $this->user, $this->pass, $options);
                return $pdo;
            }catch(PDOException $e){
                print_r("Error connection: " . $e->getMessage());
            }
        } 
    }
    
    
?>

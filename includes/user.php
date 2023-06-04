<?php

    include_once 'db.php';

    class User extends DB {
        private $nombre;
        private $userName;

        public function userExists($user, $pass) {

            $query = $this->connect()->prepare('SELECT * FROM `Customers` WHERE email = :email AND pass = :pass');
            $query->execute(['email' => $user, 'pass' => $pass]);

            if ($query->rowCount()) {
                return true;
            }else{
                return false;
            }

        }

        public function setUser($user) {
            $query = $this->connect()->prepare('SELECT * FROM `Customers` WHERE email = :email');
            $query -> execute(['email' => $user]);

            foreach ($query as $currentUser) {
                $this->nombre = $currentUser['name_customer'];
                $this->userName = $currentUser['email'];
            }
        }

        public function getUser() {
            return $this->nombre;
        }

        public function isAdmin($user) {
            $query = $this->connect()->prepare('SELECT Administradores.dni FROM Customers, Administradores WHERE Customers.email = :email AND Customers.dni = Administradores.dni;');
            $query->execute([':email' => $user]);
            

            if($query->rowCount()){
                return true;
            }else{
                return false;
            }
        }
    }
?>
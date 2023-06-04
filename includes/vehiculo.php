<?php
include_once 'db.php';

class Vehiculo extends DB {
    private $model;
    private $brand;
    private $license_plate;
    private $nombre_tipo;
    private $alquilado;
    private $id_modelo;

    public function __construct($license_plate) {
        $this->license_plate = $license_plate;
    }

    public function getLicensePlate() {
        return $this->license_plate;
    }

    public function getModel() {
        return $this->model;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getNombreTipo() {
        return $this->nombre_tipo;
    }

    public function isAlquilado() {
        return $this->alquilado;
    }

    public function getIdModelo() {
        return $this->id_modelo;
    }

    public function loadFromDatabase() {
        $query = $this->connect()->prepare('SELECT * FROM `Vehicles` WHERE license_plate = :license_plate');
        $query->execute(['license_plate' => $this->license_plate]);

        if ($query->rowCount()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->model = $result['model'];
            $this->brand = $result['brand'];
            $this->nombre_tipo = $result['nombre_tipo'];
            $this->alquilado = $result['alquilado'];
            $this->id_modelo = $result['id_modelo'];
            return true;
        } else {
            return false;
        }
    }
}

?>
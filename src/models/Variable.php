<?php
require_once __DIR__ . '/../../config.php';

class Variable {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    public function getAllWeather() {
        $stmt = $this->conn->query("SELECT * FROM weather_conditions ORDER BY name");
        return $stmt->fetchAll();
    }
    
    public function getAllRoadTypes() {
        $stmt = $this->conn->query("SELECT * FROM road_types ORDER BY name");
        return $stmt->fetchAll();
    }
    
    public function getAllTraffic() {
        $stmt = $this->conn->query("SELECT * FROM traffic_conditions ORDER BY name");
        return $stmt->fetchAll();
    }
    
    public function addWeather($name) {
        $stmt = $this->conn->prepare("INSERT INTO weather_conditions (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
    
    public function addRoadType($name) {
        $stmt = $this->conn->prepare("INSERT INTO road_types (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
    
    public function addTraffic($name) {
        $stmt = $this->conn->prepare("INSERT INTO traffic_conditions (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
}


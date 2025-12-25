<?php
require_once __DIR__ . '/../../config.php';

class Experience {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    public function create($userId, $date, $startTime, $endTime, $kilometers, $notes, $weatherIds, $roadTypeIds, $trafficIds) {
        try {
            $this->conn->beginTransaction();
            
            $stmt = $this->conn->prepare("INSERT INTO driving_experiences (user_id, date, start_time, end_time, kilometers, notes) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $date, $startTime, $endTime, $kilometers, $notes]);
            $experienceId = $this->conn->lastInsertId();
            
            $this->linkWeather($experienceId, $weatherIds);
            $this->linkRoadTypes($experienceId, $roadTypeIds);
            $this->linkTraffic($experienceId, $trafficIds);
            
            $this->conn->commit();
            return $experienceId;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error creating experience: " . $e->getMessage());
            return false;
        }
    }
    
    private function linkWeather($experienceId, $weatherIds) {
        if (empty($weatherIds)) return;
        $stmt = $this->conn->prepare("INSERT INTO experience_weather (experience_id, weather_id) VALUES (?, ?)");
        foreach ($weatherIds as $weatherId) {
            $stmt->execute([$experienceId, $weatherId]);
        }
    }
    
    private function linkRoadTypes($experienceId, $roadTypeIds) {
        if (empty($roadTypeIds)) return;
        $stmt = $this->conn->prepare("INSERT INTO experience_road_types (experience_id, road_type_id) VALUES (?, ?)");
        foreach ($roadTypeIds as $roadTypeId) {
            $stmt->execute([$experienceId, $roadTypeId]);
        }
    }
    
    private function linkTraffic($experienceId, $trafficIds) {
        if (empty($trafficIds)) return;
        $stmt = $this->conn->prepare("INSERT INTO experience_traffic (experience_id, traffic_id) VALUES (?, ?)");
        foreach ($trafficIds as $trafficId) {
            $stmt->execute([$experienceId, $trafficId]);
        }
    }
    
    public function getAll($userId, $filters = []) {
        $sql = "SELECT de.*, 
                GROUP_CONCAT(DISTINCT w.name) as weather,
                GROUP_CONCAT(DISTINCT rt.name) as road_types,
                GROUP_CONCAT(DISTINCT tc.name) as traffic
                FROM driving_experiences de
                LEFT JOIN experience_weather ew ON de.id = ew.experience_id
                LEFT JOIN weather_conditions w ON ew.weather_id = w.id
                LEFT JOIN experience_road_types ert ON de.id = ert.experience_id
                LEFT JOIN road_types rt ON ert.road_type_id = rt.id
                LEFT JOIN experience_traffic et ON de.id = et.experience_id
                LEFT JOIN traffic_conditions tc ON et.traffic_id = tc.id
                WHERE de.user_id = ?";
        
        $params = [$userId];
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND de.date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND de.date <= ?";
            $params[] = $filters['date_to'];
        }
        
        if (!empty($filters['weather_id'])) {
            $sql .= " AND de.id IN (SELECT experience_id FROM experience_weather WHERE experience_id = de.id AND weather_id = ?)";
            $params[] = $filters['weather_id'];
        }
        
        $sql .= " GROUP BY de.id ORDER BY de.date DESC, de.start_time DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getTotalKilometers($userId, $filters = []) {
        $sql = "SELECT SUM(kilometers) as total FROM driving_experiences WHERE user_id = ?";
        $params = [$userId];
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND date <= ?";
            $params[] = $filters['date_to'];
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    public function getStatistics($userId) {
        $stats = [];
        
        $stmt = $this->conn->prepare("SELECT w.name, COUNT(ew.experience_id) as count 
                                    FROM weather_conditions w 
                                    LEFT JOIN experience_weather ew ON w.id = ew.weather_id 
                                    LEFT JOIN driving_experiences de ON ew.experience_id = de.id AND de.user_id = ?
                                    GROUP BY w.id, w.name 
                                    ORDER BY count DESC");
        $stmt->execute([$userId]);
        $stats['weather'] = $stmt->fetchAll();
        
        $stmt = $this->conn->prepare("SELECT rt.name, COUNT(ert.experience_id) as count 
                                    FROM road_types rt 
                                    LEFT JOIN experience_road_types ert ON rt.id = ert.road_type_id 
                                    LEFT JOIN driving_experiences de ON ert.experience_id = de.id AND de.user_id = ?
                                    GROUP BY rt.id, rt.name 
                                    ORDER BY count DESC");
        $stmt->execute([$userId]);
        $stats['road_types'] = $stmt->fetchAll();
        
        $stmt = $this->conn->prepare("SELECT tc.name, COUNT(et.experience_id) as count 
                                    FROM traffic_conditions tc 
                                    LEFT JOIN experience_traffic et ON tc.id = et.traffic_id 
                                    LEFT JOIN driving_experiences de ON et.experience_id = de.id AND de.user_id = ?
                                    GROUP BY tc.id, tc.name 
                                    ORDER BY count DESC");
        $stmt->execute([$userId]);
        $stats['traffic'] = $stmt->fetchAll();
        
        $stmt = $this->conn->prepare("SELECT DATE_FORMAT(date, '%Y-%m') as month, SUM(kilometers) as km 
                                    FROM driving_experiences 
                                    WHERE user_id = ?
                                    GROUP BY month 
                                    ORDER BY month DESC 
                                    LIMIT 12");
        $stmt->execute([$userId]);
        $stats['monthly_km'] = $stmt->fetchAll();
        
        return $stats;
    }
    
    public function delete($id, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM driving_experiences WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }
}


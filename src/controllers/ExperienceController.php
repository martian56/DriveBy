<?php
require_once __DIR__ . '/../models/Experience.php';
require_once __DIR__ . '/../models/Variable.php';

class ExperienceController {
    private $experience;
    private $variable;
    
    public function __construct() {
        $this->experience = new Experience();
        $this->variable = new Variable();
    }
    
    public function handleSubmit($userId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
            $date = $_POST['date'] ?? '';
            $startTime = $_POST['start_time'] ?? '';
            $endTime = $_POST['end_time'] ?? '';
            $kilometers = $_POST['kilometers'] ?? 0;
            $notes = $_POST['notes'] ?? '';
            $weatherIds = $_POST['weather'] ?? [];
            $roadTypeIds = $_POST['road_types'] ?? [];
            $trafficIds = $_POST['traffic'] ?? [];
            
            if (empty($date) || empty($startTime) || empty($endTime) || empty($kilometers)) {
                $_SESSION['error'] = 'Please fill in all required fields.';
                return false;
            }
            
            if ($startTime >= $endTime) {
                $_SESSION['error'] = 'End time must be after start time.';
                return false;
            }
            
            $result = $this->experience->create($userId, $date, $startTime, $endTime, $kilometers, $notes, $weatherIds, $roadTypeIds, $trafficIds);
            
            if ($result) {
                $_SESSION['success'] = 'Driving experience added successfully!';
                header('Location: index.php?page=summary');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to add driving experience.';
                return false;
            }
        }
        return false;
    }
    
    public function handleDelete($userId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
            $id = $_POST['id'] ?? 0;
            if ($id > 0) {
                $this->experience->delete($id, $userId);
                $_SESSION['success'] = 'Experience deleted successfully!';
                header('Location: index.php?page=summary');
                exit;
            }
        }
    }
    
    public function getFormData() {
        return [
            'weather' => $this->variable->getAllWeather(),
            'road_types' => $this->variable->getAllRoadTypes(),
            'traffic' => $this->variable->getAllTraffic()
        ];
    }
    
    public function getSummaryData($userId, $filters = []) {
        return [
            'experiences' => $this->experience->getAll($userId, $filters),
            'total_km' => $this->experience->getTotalKilometers($userId, $filters)
        ];
    }
    
    public function getStatistics($userId) {
        return $this->experience->getStatistics($userId);
    }
}


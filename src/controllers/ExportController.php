<?php
require_once __DIR__ . '/../models/Experience.php';

class ExportController {
    private $experience;
    
    public function __construct() {
        $this->experience = new Experience();
    }
    
    public function exportToCSV($userId, $filters = []) {
        $experiences = $this->experience->getAll($userId, $filters);
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="drive-by-export-' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, ['Date', 'Start Time', 'End Time', 'Kilometers', 'Weather', 'Road Types', 'Traffic', 'Notes']);
        
        foreach ($experiences as $exp) {
            fputcsv($output, [
                $exp['date'],
                $exp['start_time'] ?? '',
                $exp['end_time'] ?? '',
                $exp['kilometers'],
                $exp['weather'] ?? 'N/A',
                $exp['road_types'] ?? 'N/A',
                $exp['traffic'] ?? 'N/A',
                $exp['notes'] ?? ''
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    public function exportStatisticsToCSV($userId) {
        $stats = $this->experience->getStatistics($userId);
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="drive-by-statistics-' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, ['Statistics Report - Drive By']);
        fputcsv($output, ['Generated: ' . date('Y-m-d H:i:s')]);
        fputcsv($output, []);
        
        fputcsv($output, ['Weather Conditions Distribution']);
        fputcsv($output, ['Weather', 'Count']);
        foreach ($stats['weather'] as $weather) {
            fputcsv($output, [$weather['name'], $weather['count']]);
        }
        
        fputcsv($output, []);
        fputcsv($output, ['Road Types Distribution']);
        fputcsv($output, ['Road Type', 'Count']);
        foreach ($stats['road_types'] as $roadType) {
            fputcsv($output, [$roadType['name'], $roadType['count']]);
        }
        
        fputcsv($output, []);
        fputcsv($output, ['Traffic Conditions Distribution']);
        fputcsv($output, ['Traffic Condition', 'Count']);
        foreach ($stats['traffic'] as $traffic) {
            fputcsv($output, [$traffic['name'], $traffic['count']]);
        }
        
        fputcsv($output, []);
        fputcsv($output, ['Monthly Kilometers']);
        fputcsv($output, ['Month', 'Kilometers']);
        foreach ($stats['monthly_km'] as $monthly) {
            fputcsv($output, [$monthly['month'], $monthly['km']]);
        }
        
        fclose($output);
        exit;
    }
}


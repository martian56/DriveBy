<?php
require_once __DIR__ . '/config.php';

$conn = null;

function get_connection() {
    global $conn;
    
    if ($conn !== null) {
        return $conn;
    }
    
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
        $tempConn = new PDO($dsn, DB_USER, DB_PASSWORD);
        $tempConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $tempConn->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $tempConn->exec("USE " . DB_NAME);
        
        $conn = $tempConn;
        initializeTables($conn);
        
        return $conn;
    } catch (Exception $e) {
        error_log("Database connection error: " . $e->getMessage());
        return null;
    }
}

function initializeTables($conn) {
    try {
        $conn->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $conn->exec("CREATE TABLE IF NOT EXISTS weather_conditions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $conn->exec("CREATE TABLE IF NOT EXISTS road_types (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $conn->exec("CREATE TABLE IF NOT EXISTS traffic_conditions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $conn->exec("CREATE TABLE IF NOT EXISTS driving_experiences (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            date DATE NOT NULL,
            start_time TIME NOT NULL,
            end_time TIME NOT NULL,
            kilometers DECIMAL(10, 2) NOT NULL,
            notes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            INDEX idx_date (date),
            INDEX idx_user_id (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $conn->exec("CREATE TABLE IF NOT EXISTS experience_weather (
            experience_id INT NOT NULL,
            weather_id INT NOT NULL,
            PRIMARY KEY (experience_id, weather_id),
            FOREIGN KEY (experience_id) REFERENCES driving_experiences(id) ON DELETE CASCADE,
            FOREIGN KEY (weather_id) REFERENCES weather_conditions(id) ON DELETE CASCADE,
            INDEX idx_weather (weather_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $conn->exec("CREATE TABLE IF NOT EXISTS experience_road_types (
            experience_id INT NOT NULL,
            road_type_id INT NOT NULL,
            PRIMARY KEY (experience_id, road_type_id),
            FOREIGN KEY (experience_id) REFERENCES driving_experiences(id) ON DELETE CASCADE,
            FOREIGN KEY (road_type_id) REFERENCES road_types(id) ON DELETE CASCADE,
            INDEX idx_road_type (road_type_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $conn->exec("CREATE TABLE IF NOT EXISTS experience_traffic (
            experience_id INT NOT NULL,
            traffic_id INT NOT NULL,
            PRIMARY KEY (experience_id, traffic_id),
            FOREIGN KEY (experience_id) REFERENCES driving_experiences(id) ON DELETE CASCADE,
            FOREIGN KEY (traffic_id) REFERENCES traffic_conditions(id) ON DELETE CASCADE,
            INDEX idx_traffic (traffic_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        $stmt = $conn->query("SELECT COUNT(*) as count FROM weather_conditions");
        $result = $stmt->fetch();
        if ($result['count'] == 0) {
            $conn->exec("INSERT INTO weather_conditions (name) VALUES
                ('Sunny'), ('Cloudy'), ('Rainy'), ('Foggy'), ('Snowy'), ('Windy')");
        }
        
        $stmt = $conn->query("SELECT COUNT(*) as count FROM road_types");
        $result = $stmt->fetch();
        if ($result['count'] == 0) {
            $conn->exec("INSERT INTO road_types (name) VALUES
                ('Highway'), ('City Street'), ('Rural Road'), ('Mountain Road'), ('Parking Lot'), ('Residential Area')");
        }
        
        $stmt = $conn->query("SELECT COUNT(*) as count FROM traffic_conditions");
        $result = $stmt->fetch();
        if ($result['count'] == 0) {
            $conn->exec("INSERT INTO traffic_conditions (name) VALUES
                ('Light Traffic'), ('Moderate Traffic'), ('Heavy Traffic'), ('No Traffic'), ('Rush Hour'), ('Construction Zone')");
        }
        
        try {
            $allColumns = $conn->query("SHOW COLUMNS FROM driving_experiences")->fetchAll(PDO::FETCH_COLUMN);
            $hasOldTime = in_array('time', $allColumns);
            $hasStartTime = in_array('start_time', $allColumns);
            $hasEndTime = in_array('end_time', $allColumns);
            
            if ($hasOldTime && !$hasStartTime && !$hasEndTime) {
                $conn->exec("ALTER TABLE driving_experiences 
                            ADD COLUMN start_time TIME NOT NULL DEFAULT '00:00:00' AFTER date,
                            ADD COLUMN end_time TIME NOT NULL DEFAULT '01:00:00' AFTER start_time");
                $conn->exec("UPDATE driving_experiences SET start_time = time, end_time = ADDTIME(time, '01:00:00')");
                $conn->exec("ALTER TABLE driving_experiences DROP COLUMN time");
            } else {
                if (!$hasStartTime) {
                    $conn->exec("ALTER TABLE driving_experiences 
                                ADD COLUMN start_time TIME NOT NULL DEFAULT '00:00:00' AFTER date");
                }
                if (!$hasEndTime) {
                    $afterColumn = $hasStartTime ? 'start_time' : 'date';
                    $conn->exec("ALTER TABLE driving_experiences 
                                ADD COLUMN end_time TIME NOT NULL DEFAULT '01:00:00' AFTER " . $afterColumn);
                }
            }
        } catch (PDOException $e) {
            error_log("Migration error: " . $e->getMessage());
        }
        
    } catch (PDOException $e) {
        error_log("Table initialization error: " . $e->getMessage());
    }
}

$conn = get_connection();
?>

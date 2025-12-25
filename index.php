<?php
require_once __DIR__ . '/src/includes/session.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/src/controllers/ExperienceController.php';
require_once __DIR__ . '/src/controllers/ExportController.php';

$page = $_GET['page'] ?? 'landing';
$authController = new AuthController();
$experienceController = new ExperienceController();
$exportController = new ExportController();

if ($page === 'logout') {
    $authController->handleLogout();
}

if ($page === 'login') {
    $authController->handleLogin();
} elseif ($page === 'register') {
    $authController->handleRegister();
}

$protectedPages = ['dashboard', 'form', 'summary', 'statistics'];
if (in_array($page, $protectedPages)) {
    $authController->requireAuth();
}

if ($page === 'landing' && $authController->isLoggedIn()) {
    $page = 'dashboard';
}

$userId = $authController->getCurrentUserId();
$controller = $experienceController;

if ($page === 'form' && $userId) {
    $experienceController->handleSubmit($userId);
} elseif ($page === 'summary' && $userId) {
    $experienceController->handleDelete($userId);
} elseif ($page === 'export' && $userId) {
    $filters = [
        'date_from' => $_GET['date_from'] ?? '',
        'date_to' => $_GET['date_to'] ?? '',
        'weather_id' => $_GET['weather_id'] ?? ''
    ];
    $exportController->exportToCSV($userId, $filters);
} elseif ($page === 'export-stats' && $userId) {
    $exportController->exportStatisticsToCSV($userId);
}

require_once __DIR__ . '/src/views/header.php';
require_once __DIR__ . '/src/includes/flash.php';
displayFlashMessages();

switch ($page) {
    case 'login':
        require_once __DIR__ . '/src/views/login.php';
        break;
    case 'register':
        require_once __DIR__ . '/src/views/register.php';
        break;
    case 'form':
        require_once __DIR__ . '/src/views/form.php';
        break;
    case 'summary':
        require_once __DIR__ . '/src/views/summary.php';
        break;
    case 'statistics':
        require_once __DIR__ . '/src/views/statistics.php';
        break;
    case 'dashboard':
        require_once __DIR__ . '/src/views/dashboard.php';
        break;
    case 'landing':
    default:
        require_once __DIR__ . '/src/views/landing.php';
        break;
}

require_once __DIR__ . '/src/views/footer.php';
?>

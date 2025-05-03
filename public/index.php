<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Set error reporting for development
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Basic routing
$request = $_SERVER['REQUEST_URI'];
// No need for basePath as DocumentRoot points directly to public folder

// Check if user is not logged in and trying to access protected routes
if (!isset($_SESSION['user_id']) && $request !== '/' && $request !== '' && !preg_match('/^\/auth\//', $request)) {
    header('Location: /auth/login');
    exit;
}

// Handle routes
if ($request === '/' || $request === '') {
    if (!isset($_SESSION['user_id'])) {
        require __DIR__ . '/../src/Views/auth/login.php';
    } else {
        require __DIR__ . '/../src/Controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
    }
} elseif (preg_match('/^\/dashboard/', $request)) {
    require __DIR__ . '/../src/Controllers/DashboardController.php';
    $controller = new DashboardController();
    $controller->index();
} else {
    http_response_code(404);
    require __DIR__ . '/../src/Views/errors/404.php';
}
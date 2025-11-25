<?php
// config.php
// Put this file in the php/ folder and include it at the top of every page:
// require_once __DIR__ . '/config.php';

date_default_timezone_set('UTC');

// Application root and log folder
define('APP_ROOT', __DIR__);
$logDir = APP_ROOT . '/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}

// Development-friendly error display (turn off in production)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('error_log', $logDir . '/php_error.log');

// Database configuration - change to your credentials
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'university');
define('DB_USER', 'root');
define('DB_PASS', '');

// Status constants
define('STATUS_ACTIVE', 'Active');
define('STATUS_PENDING', 'Pending');
define('STATUS_INACTIVE', 'Inactive');

// PDO connection (available as $pdo)
$pdo = null;
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log('DB connection failed: ' . $e->getMessage());
    http_response_code(500);
    echo "<h1>Application error</h1><p>Unable to connect to the database. Check configuration in config.php.</p>";
    exit;
}
<?php
// test_debug.php — quick diagnostics
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

echo "<h2>Debug: test_debug.php</h2>";

$configPath = __DIR__ . '/config.php';
if (!file_exists($configPath)) {
    echo "<p style='color:red;'>Missing config.php at: " . htmlspecialchars($configPath) . "</p>";
    exit;
}

echo "<p>Including config.php...</p>";
require_once $configPath;
echo "<p style='color:green;'>Included config.php</p>";

if (defined('APP_ROOT')) {
    echo "<p>APP_ROOT = " . htmlspecialchars(APP_ROOT) . "</p>";
} else {
    echo "<p style='color:orange;'>APP_ROOT is not defined.</p>";
}

$logFile = APP_ROOT . '/logs/php_error.log';
if (file_exists($logFile)) {
    echo "<p>Showing last 60 lines of " . htmlspecialchars($logFile) . ":</p><pre style='background:#f6f6f6;border:1px solid #ddd;padding:8px;max-height:300px;overflow:auto;'>";
    $lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        echo "Unable to read log file (permissions?)";
    } else {
        $tail = array_slice($lines, -60);
        foreach ($tail as $l) echo htmlspecialchars($l) . "\n";
    }
    echo "</pre>";
} else {
    echo "<p>Log file not found at: " . htmlspecialchars($logFile) . "</p>";
}

echo "<h3>DB check</h3>";
if (isset($pdo) && $pdo instanceof PDO) {
    echo "<p style='color:green;'>\$pdo is set (PDO instance).</p>";
    try {
        $stmt = $pdo->query("SELECT COUNT(*) AS cnt FROM students");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>students table count: " . htmlspecialchars((string)($row['cnt'] ?? 'n/a')) . "</p>";
    } catch (Throwable $e) {
        echo "<p style='color:red;'>Query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color:red;'>\$pdo is NOT set. Database connection failed in config.php or was not created.</p>";
}

echo "<h3>Environment</h3>";
echo "<p>PHP version: " . htmlspecialchars(phpversion()) . "</p>";
echo "<p>DocumentRoot: " . htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? 'n/a') . "</p>";
echo "<p>Requested script: " . htmlspecialchars($_SERVER['SCRIPT_FILENAME'] ?? 'n/a') . "</p>";

$fnPath = __DIR__ . '/includes/functions.php';
if (file_exists($fnPath)) {
    echo "<p>Found includes/functions.php. Attempting to include it...</p>";
    try {
        require_once $fnPath;
        echo "<p style='color:green;'>Included functions.php successfully.</p>";
    } catch (Throwable $e) {
        echo "<p style='color:red;'>Including functions.php failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>includes/functions.php not found.</p>";
}

echo "<p>End of debug.</p>";
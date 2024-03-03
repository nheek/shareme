<?php

function parse_env($filePath) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Ignore comments
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if (!array_key_exists($key, $_ENV)) {
            putenv("$key=$value"); // Set environment variable
            $_ENV[$key] = $value;  // Update $_ENV array
        }
    }
}

// Parse .env file
parse_env('.env');

// Database connection
$sqlHost = $_ENV['MYSQL_HOST'] ?? '';
$sqlUser = $_ENV['MYSQL_USER'] ?? '';
$sqlPass = $_ENV['MYSQL_PASSWORD'] ?? '';
$sqlName = $_ENV['MYSQL_DATABASE'] ?? '';

// Establish database connection
$sqlConnect = new mysqli($sqlHost, $sqlUser, $sqlPass, $sqlName);

// Check for connection errors
if ($sqlConnect->connect_errno) {
    die("Failed to connect to MySQL: " . $sqlConnect->connect_error);
}
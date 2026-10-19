<?php
/**
 * Konfigurasi Database
 * SDN 1 UNDUOLO - Sistem Manajemen Sekolah
 */

// Konfigurasi Database
if (is_file(__DIR__ . '/local.php')) require __DIR__ . '/local.php';
defined('DB_HOST') || define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
defined('DB_USER') || define('DB_USER', getenv('DB_USER') ?: 'root');
defined('DB_PASS') || define('DB_PASS', getenv('DB_PASS') ?: '');
defined('DB_NAME') || define('DB_NAME', getenv('DB_NAME') ?: 'sdn1unduolo');

// Konfigurasi Aplikasi
define('APP_NAME', 'SDN 1 UNDUOLO');

// Auto-detect BASE_URL
if (!defined('BASE_URL')) {
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $file = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
    $root = str_replace('\\', '/', dirname(__DIR__));
    $relative = substr($file, strlen($root));
    $basePath = $relative && str_ends_with($script, $relative) ? substr($script, 0, -strlen($relative)) : '';
    define('BASE_URL', rtrim(getenv('APP_BASE_URL') ?: $basePath, '/'));
}

// Timezone
date_default_timezone_set('Asia/Makassar');

/**
 * Koneksi ke Database
 */
function getDB() {
    static $conn = null;
    
    if ($conn === null) {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($conn->connect_error) {
                die("Koneksi database gagal: " . $conn->connect_error);
            }
            
            $conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(503);
            exit('Database belum tersedia. Periksa konfigurasi dan layanan MySQL.');
        }
    }
    
    return $conn;
}

/**
 * Escape string untuk mencegah SQL Injection
 */
function escape($string) {
    return getDB()->real_escape_string($string);
}

/**
 * Query helper
 */
function query($sql) {
    return getDB()->query($sql);
}

/**
 * Fetch single row
 */
function fetchOne($sql) {
    $result = query($sql);
    return $result ? $result->fetch_assoc() : null;
}

/**
 * Fetch all rows
 */
function fetchAll($sql) {
    $result = query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Get last insert ID
 */
function lastInsertId() {
    return getDB()->insert_id;
}


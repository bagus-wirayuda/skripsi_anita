<?php
/**
 * Konfigurasi Database
 * SDN 1 UNDUOLO - Sistem Manajemen Sekolah
 */

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sdn1unduolo');

// Konfigurasi Aplikasi
define('APP_NAME', 'SDN 1 UNDUOLO');

// Auto-detect BASE_URL
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    // Get base path from document root
    $docRoot = $_SERVER['DOCUMENT_ROOT'];
    $scriptFile = $_SERVER['SCRIPT_FILENAME'];
    $basePath = str_replace('\\', '/', str_replace($docRoot, '', dirname($scriptFile)));
    $basePath = rtrim($basePath, '/');
    // If empty, use script directory
    if (empty($basePath)) {
        $basePath = dirname($script);
        $basePath = rtrim($basePath, '/');
    }
    define('BASE_URL', $protocol . '://' . $host . $basePath);
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
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($conn->connect_error) {
                die("Koneksi database gagal: " . $conn->connect_error);
            }
            
            $conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Error koneksi database: " . $e->getMessage());
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


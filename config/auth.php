<?php
/**
 * Sistem Autentikasi
 * SDN 1 UNDUOLO - Sistem Manajemen Sekolah
 */

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start(['cookie_httponly'=>true, 'cookie_samesite'=>'Lax', 'cookie_secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
}
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && !hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
    http_response_code(419);
    exit('Sesi formulir telah berakhir. Muat ulang halaman lalu coba kembali.');
}

require_once __DIR__ . '/database.php';

/**
 * Cek apakah user sudah login
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

/**
 * Cek role user
 */
function checkRole($allowedRoles = []) {
    if (!isLoggedIn()) {
        return false;
    }
    
    if (empty($allowedRoles)) {
        return true;
    }
    
    return in_array($_SESSION['role'], $allowedRoles);
}

/**
 * Redirect jika belum login
 */
function requireLogin() {
    if (isLoggedIn()) {
        $id = (int)$_SESSION['user_id'];
        $u = fetchOne("SELECT * FROM users WHERE id=$id AND status='aktif'");
        if (!$u || $u['role'] !== $_SESSION['role']) {
            session_unset();
        } else {
            $_SESSION['nama_lengkap'] = $u['nama_lengkap'];
            $role = $u['role'];
            $related = $role === 'guru' ? fetchOne("SELECT id FROM guru WHERE user_id=$id AND status='aktif'") : ($role === 'orangtua' ? fetchOne("SELECT id FROM orangtua WHERE user_id=$id AND status='approved'") : null);
            $_SESSION['related_id'] = $related['id'] ?? null;
            if (in_array($role, ['guru','orangtua']) && !$related) session_unset();
        }
    }
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/login.php');
        exit;
    }
}

/**
 * Redirect berdasarkan role
 */
function requireRole($allowedRoles) {
    requireLogin();
    
    if (!checkRole($allowedRoles)) {
        http_response_code(403);
        echo 'Anda tidak memiliki akses ke halaman ini.';
        exit;
    }
}

/**
 * Login user
 */
function login($username, $password) {
    $username = escape($username);
    $sql = "SELECT u.*, 
                   CASE 
                       WHEN u.role = 'guru' THEN g.id
                       WHEN u.role = 'orangtua' THEN o.id
                       ELSE NULL
                   END as related_id
            FROM users u
            LEFT JOIN guru g ON u.id = g.user_id
            LEFT JOIN orangtua o ON u.id = o.user_id
            WHERE (u.username = '$username' OR u.email = '$username') AND u.status = 'aktif'";
    
    $user = fetchOne($sql);
    
    if ($user && password_verify($password, $user['password'])) {
        if ($user['role'] === 'guru' && !fetchOne('SELECT id FROM guru WHERE user_id='.(int)$user['id']." AND status='aktif'")) return false;
        if ($user['role'] === 'orangtua' && !fetchOne('SELECT id FROM orangtua WHERE user_id='.(int)$user['id']." AND status='approved'")) return false;
        session_regenerate_id(true);
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['related_id'] = $user['related_id'] ?? null;
        
        // Update last login
        $userId = $user['id'];
        $now = date('Y-m-d H:i:s');
        query("UPDATE users SET last_login = '$now' WHERE id = $userId");
        
        return true;
    }
    
    return false;
}

/**
 * Logout user
 */
function logout() {
    session_unset();
    session_destroy();
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

/**
 * Get current user data
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = $userId";
    return fetchOne($sql);
}

/**
 * Get redirect URL berdasarkan role
 */
function getRedirectUrl($role) {
    switch ($role) {
        case 'admin':
            return BASE_URL . '/admin/dashboard.php';
        case 'guru':
            return BASE_URL . '/guru/dashboard.php';
        case 'kepalasekolah':
            return BASE_URL . '/kepalasekolah/dashboard.php';
        case 'orangtua':
            return BASE_URL . '/orangtua/dashboard.php';
        default:
            return BASE_URL . '/login.php';
    }
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Generate username from nama
 */
function generateUsername($nama) {
    $username = strtolower($nama);
    $username = preg_replace('/[^a-z0-9]/', '', $username);
    $username = substr($username, 0, 10);
    
    // Check if username exists
    $counter = 1;
    $originalUsername = $username;
    while (fetchOne("SELECT id FROM users WHERE username = '$username'")) {
        $username = $originalUsername . $counter;
        $counter++;
    }
    
    return $username;
}



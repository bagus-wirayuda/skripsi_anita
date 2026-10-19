<?php
require_once 'config/auth.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . '/login.php'); exit; }
logout();



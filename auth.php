<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function current_user() {
    return $_SESSION['user'] ?? null;
}

function require_login() {
    if (!current_user()) {
        $redirect = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'index.php';
        header('Location: login.php?redirect=' . urlencode($redirect));
        exit;
    }
}

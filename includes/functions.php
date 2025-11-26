<?php
// includes/functions.php
session_start();
if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/employee_management');
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ' . BASE_PATH . '/pages/login.php');
        exit;
    }
}

function has_role($roles) {
    return in_array($_SESSION['role'], (array)$roles);
}

function require_role($roles) {
    require_login();
    if (!has_role($roles)) {
        die("Access denied.");
    }
}

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: " . BASE_PATH . $url);
    exit;
}

function format_date($date) {
    return $date ? date('M j, Y', strtotime($date)) : '—';
}

function format_money($amount) {
    return 'K ' . number_format($amount, 2);
}
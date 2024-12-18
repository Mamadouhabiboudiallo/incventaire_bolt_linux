<?php
/**
 * Get the base URL of the application
 */
function base_url($path = '') {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Safely redirect to another page
 */
function redirect($path) {
    header('Location: ' . base_url($path));
    exit;
}

/**
 * Escape HTML entities in a string
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Get current page name
 */
function get_current_page() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

/**
 * Check if current page is active
 */
function is_active_page($page) {
    return get_current_page() === $page;
}
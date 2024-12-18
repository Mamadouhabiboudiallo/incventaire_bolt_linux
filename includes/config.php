<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'inventory_system');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application configuration
define('BASE_URL', 'http://localhost/project_bis/project/');
define('SITE_NAME', 'Inventory Management System');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_start();
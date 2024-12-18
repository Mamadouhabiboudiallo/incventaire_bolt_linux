<?php
require_once 'config.php';
require_once 'functions.php';

// Autoload classes
spl_autoload_register(function ($class_name) {
    $paths = [
        'models/',
        'utils/',
        'config/'
    ];
    
    foreach ($paths as $path) {
        $file = __DIR__ . '/../' . $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
<?php
require_once '../../config/Database.php';
require_once '../../models/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $product = new Product($db);
    $product->id = $_POST['id'];
    
    if ($product->delete()) {
        header('Location: ../index.php');
    } else {
        // Handle error
        echo "Error deleting product.";
    }
} else {
    header('Location: ../index.php');
}
exit;
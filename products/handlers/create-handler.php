<?php
$validator = new Validator();

$product->name = $_POST['name'] ?? '';
$product->barcode = $_POST['barcode'] ?? '';
$product->quantity = $_POST['quantity'] ?? '';

$errors = $validator->validateProduct($product);

if (empty($errors)) {
    if ($product->create()) {
        header('Location: index.php');
        exit;
    } else {
        $errors[] = "Unable to create product.";
    }
}
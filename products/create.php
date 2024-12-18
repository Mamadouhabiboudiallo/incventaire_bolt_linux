<?php
require_once '../includes/header.php';
require_once '../config/Database.php';
require_once '../models/Product.php';
require_once '../utils/Validator.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'handlers/create-handler.php';
}
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add New Product</h1>
        <a href="index.php" class="btn btn-secondary">Back to Products</a>
    </div>

    <?php include 'partials/form-errors.php'; ?>

    <div class="card">
        <div class="card-body">
            <?php include 'partials/product-form.php'; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
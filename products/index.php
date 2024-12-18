<?php
require_once '../includes/header.php';
require_once '../config/Database.php';
require_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$stmt = $product->read();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Products</h1>
        <a href="create.php" class="btn btn-primary">Add New Product</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Quantity</th>
                        <th>Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'partials/product-list.php'; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>